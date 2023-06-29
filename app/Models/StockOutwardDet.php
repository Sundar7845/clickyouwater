<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockOutwardDet extends Model
{
    use HasFactory;

    protected $fillable = [
        'stock_outward_id',
        'product_id',
        'qty',
        'return_qty'
    ];
}
