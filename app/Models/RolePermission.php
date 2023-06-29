<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{
    use HasFactory;

    protected $fillable = [
        'menu_id',
        'role_id',
        'created_by',
        'updated_by',
        'deleted_by'
    ];
}
