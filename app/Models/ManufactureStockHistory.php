<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManufactureStockHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'manufacture_id',
        'product_type_id',
        'brand_id',
        'category_id',
        'product_id',
        'mf_inward_qty',
        'mf_inward_return_qty',
        'mf_logistic_inward_qty',
        'mf_damage_qty',
        'mf_filling_outward_qty',
        'mf_filling_outward_return_qty',
        'mf_production_inward_qty',
        'mf_logistic_outward_qty',
        'mf_logistic_return_qty',
        'mf_otheritems_inward_qty',
        'mf_otheritems_removed_qty'
    ];
}
