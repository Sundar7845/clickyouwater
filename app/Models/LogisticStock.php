<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogisticStock extends Model
{
    use HasFactory;

    protected $fillable = [
        'driver_id',
        'product_id',
        'order_qty',
        'filled_qty',
        'empty_qty',
        'damaged_qty'
    ];

    public function products()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }
}
