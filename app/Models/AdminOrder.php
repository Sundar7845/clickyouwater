<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_no',
        'user_id',
        'hub_id',
        'total_qty'
    ];
}
