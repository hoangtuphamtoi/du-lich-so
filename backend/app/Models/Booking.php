<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'code',
        'service_date',
        'pax',
        'status',
        'hold_expires_at',
    ];

    protected $casts = [
        'hold_expires_at' => 'datetime',
        'service_date' => 'date',
    ];
}