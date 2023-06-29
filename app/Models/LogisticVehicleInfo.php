<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LogisticVehicleInfo extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'logistic_partner_id',
        'fuel_type_id',
        'vehicle_brand_id',
        'vehicle_type_id',
        'reg_no',
        'capacity',
        'weight',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    protected $preventSoftDelete = true; // add this line

    public function logistic()
    {
        return $this->belongsTo(LogisticPartner::class, 'logistic_partner_id', 'id');
    }
}
