<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderDet extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'qty',
        'price',
        'deposit_amount',
        'igst_amount',
        'sgst_amount',
        'cgst_amount',
        'return_empty_cans_qty',
        'collected_empty_cans_qty',
        'damaged_empty_cans_qty'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function products()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }
    
}
