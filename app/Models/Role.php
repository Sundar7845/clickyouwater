<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use HasFactory;
    protected $fillable = [
        'role_name',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

}
