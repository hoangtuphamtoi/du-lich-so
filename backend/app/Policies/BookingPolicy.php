<?php

namespace App\Policies;

use App\Models\Booking;
use App\Models\User;

class BookingPolicy
{
    /**
     * Kiểm tra quyền xem đơn hàng
     */
    public function view(User $u, Booking $b): bool
    {
        return match ($u->role) {
            'admin'    => true,
            'customer' => $b->user_id === $u->id,
            'supplier' => $b->product->supplier->user_id === $u->id,
            default    => false,
        };
    }

    /**
     * Kiểm tra quyền hủy đơn hàng
     */
    public function cancel(User $u, Booking $b): bool
    {
        return $this->view($u, $b)
            && in_array($b->status, ['pending_payment', 'confirmed'], true)
            && now()->lt($b->service_date);
    }
}