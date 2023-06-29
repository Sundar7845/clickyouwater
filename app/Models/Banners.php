<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Banners extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'banner_name',
        'banner_img',
        'start_date',
        'end_date',
        'is_active',
        'created_by',
        'updated_by',
        'deleted_by'
    ];
}
