<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HubStock extends Model
{
    use HasFactory;
    protected $fillable = [
        'hub_id',
        'product_id',
        'order_qty',
        'filled_qty',
        'empty_qty',
        'damaged_qty',
        'lost_qty'
    ];

    public function products()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }

    public function hubs()
    {
        return $this->belongsTo(Hub::class, 'hub_id');
    }
}
