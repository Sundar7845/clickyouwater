<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDepositHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'delivery_address_id',
        'qty',
        'deposit_amount'
    ];

    public function products()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
