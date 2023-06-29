<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogisticTrip extends Model
{
    use HasFactory;

    protected $fillable = [
        'manufacture_id',
        'driver_id',
        'is_active',
        'trip_start_on',
        'trip_end_on'
    ];
}
