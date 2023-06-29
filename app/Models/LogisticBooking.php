<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogisticBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'trip_id',
        'booking_no',
        'manufacture_id',
        'driver_id',
        'is_cancelled',
        'cancelled_on',
        'status_id'
    ];

    public function bookingDets()
    {
        return $this->hasMany(LogisticBookingDet::class, 'logistic_booking_id');
    }
}
