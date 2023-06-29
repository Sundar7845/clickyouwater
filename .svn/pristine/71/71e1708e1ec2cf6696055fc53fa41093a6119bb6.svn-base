<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerStock extends Model
{
    use HasFactory;

    protected $fillable = [
        'address_id',
        'user_id',
        'product_id',
        'empty_qty',
        'damaged_qty',
        'extra_qty'
    ];

    public function products()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }
}
