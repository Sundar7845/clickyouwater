<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GeoApiSettings extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'api_url',
        'api_key',
        'firebase_key',
        'fcm_sender_id',
        'updated_by',
    ];
}
