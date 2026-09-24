<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookingRequest;
use App\Services\BookingService;
use Illuminate\Support\Facades\Log;
use RuntimeException;

class BookingController extends Controller
{
    public function __construct(private BookingService $bookings) {}

    public function store(StoreBookingRequest $r)
    {
        try {
            $booking = $this->bookings->hold(
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
}