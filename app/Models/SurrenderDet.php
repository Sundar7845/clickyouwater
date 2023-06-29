<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurrenderDet extends Model
{
    use HasFactory;

    protected $fillable = [
        'surrender_id',
        'qty',
        'product_id',
        'deposit_amount',
        'collected_can_qty',
        'damaged_can_qty'
    ];

    public function surrender()
    {
        return $this->belongsTo(Surrender::class);
    }

    public function surrenderPickups()
    {
        return $this->hasMany(SurrenderPickup::class, 'surrender_id');
    }
    
    public function products()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }
}
