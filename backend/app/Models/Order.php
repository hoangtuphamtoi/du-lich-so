<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'order_code',
        'customer_name',
        'customer_phone',
        'customer_address',
        'note',
        'quantity',
        'total_amount',
        'payment_method',
        'payment_status',
        'payment_proof',
        'status',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
