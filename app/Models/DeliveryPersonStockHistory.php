<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryPersonStockHistory extends Model
{
    use HasFactory;
    protected $fillable = [
        'hub_id',
        'delivery_user_id',
        'product_type_id',
        'brand_id',
        'category_id',
        'product_id',
        'inward_from_customer_qty',
        'outward_to_hub_qty',
        'inward_from_hub_qty',
        'inward_return_qty',
        'outward_to_customer_qty',
        'outward_return_qty'
    ];
}
