<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Products extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'product_name',
        'product_type_id',
        'brand_id',
        'category_id',
        'product_image',
        'customer_price',
        'wholesale_price',
        'capacity',
        'desc',
        'expiry_duration_days',
        'hsn_sac_code',
        'is_emptycan_return',
        'CGST',
        'SGST',
        'is_active',
        'created_by',
        'updated_by',
        'deleted_by'
    ];


    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function productType()
    {
        return $this->belongsTo(ProductType::class, 'product_type_id', 'id');
    }

    public function brand()
    {
        return $this->belongsTo(Brands::class, 'brand_id', 'id');
    }

    public function orderDets()
    {
        return $this->hasMany(OrderDet::class, 'product_id');
    }

    public function bookingDets()
    {
        return $this->hasMany(LogisticBookingDet::class, 'product_id');
    }

    public function surrenderDets()
    {
        return $this->hasMany(SurrenderDet::class, 'product_id');
    }

    public function customerStock()
    {
        return $this->hasMany(CustomerStock::class, 'product_id');
    }

    public function hubStock()
    {
        return $this->hasMany(HubStock::class, 'product_id');
    }

    public function logisticStock()
    {
        return $this->hasMany(LogisticStock::class, 'product_id');
    }

    public function userDeposits()
    {
        return $this->hasMany(UserDepositHistory::class, 'product_id');
    }
    public function hubCollectReturnCans()
    {
        return $this->hasMany(HubCollectReturnCans::class, 'product_id');
    }
}
