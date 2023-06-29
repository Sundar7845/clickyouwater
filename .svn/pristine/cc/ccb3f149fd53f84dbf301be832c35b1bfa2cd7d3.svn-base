<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reasons extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'reason_type_id',
        'reason',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    public function surrender()
    {
        return $this->hasMany(Surrender::class, 'reason_id');
    }
}
