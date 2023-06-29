<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReasonType extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'reason_type'
    ];
}
