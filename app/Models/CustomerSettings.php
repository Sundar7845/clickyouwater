<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerSettings extends Model
{
    use HasFactory;

    protected $fillable = [
        'place_order_within_radius',
        'customer_not_placed_order_within',
        'show_invoice_days'
    ];
}
