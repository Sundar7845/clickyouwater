<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'menu_name',
        'parent_id',
        'is_mainmenu',
        'is_module',
        'menu_order',
        'is_visible',
        'show_superadmin',
        'group_name',
        'menu_url',
        'icon'
    ];
}
