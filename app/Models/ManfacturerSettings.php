<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManfacturerSettings extends Model
{
    use HasFactory;

    protected $fillable = [
        'deliver_to_logistics_hrs'
    ];
}
