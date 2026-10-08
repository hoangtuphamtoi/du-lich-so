<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookingRequest;
use App\Models\Booking;
use App\Services\BookingService;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use RuntimeException;

class BookingController extends Controller
{
    /**
     * Trình diễn trang thông tin sản phẩm / đặt chỗ
     */
    public function showProduct($id)
    {
        // 1. Lấy dữ liệu tồn kho từ bảng availabilities
        $availability = DB::table('availabilities')->where('product_id', $id)->first();

        // 2. Giả lập đối tượng $product để trang show.blade.php đọc không bị lỗi Property/Variable
        $product = (object) [
            'id' => $id,
            'title' => 'Sản phẩm kiểm thử #' . $id,
            'cancel_policy' => 'Chính sách hoàn hủy vé áp dụng cho chương trình chạy thử nghiệm.',
            'destinations' => collect(),
            'itineraries' => collect(),
        ];

        // 3. Chuẩn bị các tập dữ liệu bổ sung
        $availabilities = collect([$availability]);
        $related = collect();

        // 4. Trả về View nếu tồn tại
        if (view()->exists('products.show')) {
            return view('products.show', compact(
                'id',
                'availability',
                'product',
                'availabilities',
                'related'
            ));
        }

        // Trường hợp chưa nhận diện được View, trả về JSON để kiểm tra
        return response()->json([
            'message' => 'Dữ liệu sản phẩm khả dụng cho kiểm thử Race Condition.',
            'product_id' => $id,
            'availability' => $availability
        ]);
    }

    /**
     * Giữ chỗ / Tạo đơn đặt hàng mới
     */
    public function store(StoreBookingRequest $r, BookingService $bookings)
    {
        try {
            $booking = $bookings->hold(
                $r->user()->id,
                (int) $r->product_id,
                $r->service_date,
                (int) $r->pax
            );
        } catch (RuntimeException $e) {
            Log::warning('Giu cho that bai', ['user' => $r->user()->id, 'loi' => $e->getMessage()]);
            return back()->withInput()->withErrors(['pax' => $e->getMessage()]);
        }

        // Luu ma don vao phien de trang thanh toan doc lai
        session(['current_booking' => $booking->code]);

        return redirect()
            ->route('payment.show', ['code' => $booking->code])
            ->with('status', "Da giu cho den {$booking->hold_expires_at->format('H:i')}.");
    }

    /**
     * Xem chi tiết đơn hàng (Ủy quyền qua BookingPolicy)
     */
    public function show(Booking $booking)
    {
        $this->authorize('view', $booking);

        return view('bookings.show', compact('booking'));
    }

    /**
     * Hủy đơn hàng (Ủy quyền qua BookingPolicy)
     */
    public function cancel(Booking $booking)
    {
        $this->authorize('cancel', $booking);

        $booking->update(['status' => 'cancelled']);

        return back()->with('success', 'Đã hủy đơn hàng thành công!');
    }

    /**
     * Tra cứu đơn hàng bằng Token đã mã hóa (Mục 6.6)
     */
    public function lookup(string $token)
    {
        try {
            // Giải mã token lấy ID đơn hàng gốc
            $id = (int) Crypt::decryptString($token);
        } catch (DecryptException $e) {
            // Trả về 404 nếu token không hợp lệ hoặc bị can thiệp
            abort(404);
        }

        $booking = Booking::findOrFail($id);

        // Kiểm tra quyền truy cập chống IDOR
        $this->authorize('view', $booking);

        return view('bookings.show', compact('booking'));
    }

    /**
     * Tải hóa đơn bảo mật qua Signed Route (Mục 6.6)
     */
    public function downloadInvoice(Booking $booking)
    {
        $this->authorize('view', $booking);

        // Trả về file hóa đơn PDF tương ứng
        return response()->download(storage_path("app/invoices/invoice-{$booking->id}.pdf"));
    }
}