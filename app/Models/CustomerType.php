<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerType extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'customer_type',
        'is_active'
    ];
}
