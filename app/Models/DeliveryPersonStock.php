<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryPersonStock extends Model
{
    use HasFactory;

    protected $fillable = [
        'hub_id',
        'delivery_user_id',
        'product_id',
        'qty',
        'extra_qty',
        'return_empty_qty',
        'collected_empty_qty',
        'return_damaged_qty',
        'lost_qty'
    ];
}
