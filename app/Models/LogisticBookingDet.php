<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogisticBookingDet extends Model
{
    use HasFactory;

    protected $fillable = [
        'logistic_booking_id',
        'hub_id',
        'product_id',
        'qty',
        'received_qty',
        'return_damaged_qty',
        'is_hub_confirmed',
        'delivered_on'
    ];

    public function booking()
    {
        return $this->belongsTo(LogisticBooking::class, 'logistic_booking_id');
    }

    public function products()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }
}
