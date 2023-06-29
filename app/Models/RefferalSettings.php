<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefferalSettings extends Model
{
    use HasFactory;

    protected $fillable = [
        'referral_content',
        'earnpoints_per_referral',
        'earnpoints_per_referrer',
        'referral_banner_path'
    ];
}
