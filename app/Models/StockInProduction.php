<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockInProduction extends Model
{
    use HasFactory;

    protected $fillable = [
        'manufacture_id',
        'product_id',
        'qty'
    ];

    public function products()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }
}
