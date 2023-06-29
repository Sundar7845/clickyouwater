<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HubSettings extends Model
{
    use HasFactory;

    protected $fillable = [
        'extra_charges_per_km'
    ];
}
