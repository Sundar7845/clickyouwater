<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'coupon_type_id',
        'coupon_name',
        'coupon_code',
        'start_date',
        'end_date',
        'same_user_limit',
        'discount_type_id',
        'discount_value',
        'max_discount',
        'min_order_qty',
        'is_active',
        'created_by',
        'updated_by',
        'deleted_by'
    ];
}
