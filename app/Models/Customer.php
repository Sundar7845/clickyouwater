<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'customertype_id',
        'customer_name',
        'mobile',
        'email',
        'company',
        'isWeb',
        'created_by',
        'updated_by',
        'deleted_by'
    ];
}
