<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerNearestHub extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'customer_address_id',
        'hub_id',
        'distance'
    ];
}
