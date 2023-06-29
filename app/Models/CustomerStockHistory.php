<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerStockHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_type_id',
        'brand_id',
        'category_id',
        'product_id',
        'inward_from_delivery_qty',
        'outward_empty_to_delivery_qty',
        'outward_return_qty'
    ];
}
