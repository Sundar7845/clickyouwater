<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryVehicleInfo extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'hub_id',
        'delivery_people_id',
        'hub_vehicle_info_id'
    ];
}
