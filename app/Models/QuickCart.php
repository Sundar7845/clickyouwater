<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuickCart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'qty',
        'return_empty_cans_qty'
    ];

    public function products()
    {
        return $this->belongsTo(Products::class, 'product_id', 'id');
    }
}
