<?php

namespace App\Services;

use App\Models\{Availability, Booking, BookingStatusLog, Product};
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use RuntimeException;

class BookingService
{
    public const HOLD_MINUTES = 15;

    /**
     * Tạo phiếu giữ chỗ. Trả về Booking ở trạng thái pending_payment.
     * @throws RuntimeException khi không còn đủ chỗ khả dụng
     */
    public function hold(int $userId, int $productId, string $date, int $pax): Booking
    {
        return DB::transaction(function () use ($userId, $productId, $date, $pax) {
            // Khóa hàng tồn khả dụng: các phiên khác phải chờ đến khi giao dịch kết thúc
            $av = Availability::where('product_id', $productId)
                ->where('service_date', $date)
                ->lockForUpdate()
                ->first();

            if (! $av) {
                throw new RuntimeException('Ngay khoi hanh khong con duoc mo ban.');
            }

            $free = $av->seats_total - $av->seats_held - $av->seats_sold;
            if ($free < $pax) {
                throw new RuntimeException("Chi con {$free} cho kha dung cho ngay {$date}.");
            }

            $product = Product::findOrFail($productId);
            $unit = $av->price_override ?? $product->base_price;

            $av->increment('seats_held', $pax);

            $booking = Booking::create([
                'code' => strtoupper(Str::random(12)),
                'user_id' => $userId,
                'product_id' => $productId,
                'service_date' => $date,
                'pax' => $pax,
                'unit_price' => $unit,
                'total_amount' => $unit * $pax,
                'status' => 'pending_payment',
                'hold_expires_at' => now()->addMinutes(self::HOLD_MINUTES),
            ]);

            BookingStatusLog::create([
                'booking_id' => $booking->id,
                'from_status' => 'draft',
                'to_status' => 'pending_payment',
                'actor_id' => $userId,
            ]);

            return $booking;
        });
    }

    /**
     * Xác nhận thanh toán: chuyển chỗ từ "đang giữ" sang "đã bán".
     */
    public function confirmPaid(Booking $booking, string $txnRef): void
    {
        DB::transaction(function () use ($booking, $txnRef) {
            $booking->refresh();
            if ($booking->status !== 'pending_payment') {
                throw new RuntimeException('Don khong o trang thai cho thanh toan.');
            }

            $av = Availability::where('product_id', $booking->product_id)
                ->where('service_date', $booking->service_date)
                ->lockForUpdate()
                ->findOrFail();

            $av->decrement('seats_held', $booking->pax);
            $av->increment('seats_sold', $booking->pax);

            $booking->update([
                'status' => 'confirmed',
                'hold_expires_at' => null,
            ]);

            $booking->payments()->create([
                'gateway' => config('services.payment.gateway'),
                'txn_ref' => $txnRef,
                'amount' => $booking->total_amount,
                'status' => 'paid',
                'paid_at' => now(),
            ]);

            BookingStatusLog::create([
                'booking_id' => $booking->id,
                'from_status' => 'pending_payment',
                'to_status' => 'confirmed',
            ]);
        });
    }

    /**
     * Giải phóng các phiếu giữ chỗ đã hết hạn. Gọi định kỳ mỗi phút.
     */
    public function releaseExpiredHolds(): int
    {
        $n = 0;
        Booking::where('status', 'pending_payment')
            ->whereNotNull('hold_expires_at')
            ->where('hold_expires_at', '<', now())
            ->chunkById(100, function ($rows) use (&$n) {
                foreach ($rows as $b) {
                    DB::transaction(function () use ($b, &$n) {
                        $av = Availability::where('product_id', $b->product_id)
                            ->where('service_date', $b->service_date)
                            ->lockForUpdate()
                            ->first();

                        if ($av) {
                            $av->decrement('seats_held', $b->pax);
                        }

                        $b->update(['status' => 'expired']);

                        BookingStatusLog::create([
                            'booking_id' => $b->id,
                            'from_status' => 'pending_payment',
                            'to_status' => 'expired',
                            'reason' => 'Het thoi han giu cho',
                        ]);

                        $n++;
                    });
                }
            });

        return $n;
    }
}