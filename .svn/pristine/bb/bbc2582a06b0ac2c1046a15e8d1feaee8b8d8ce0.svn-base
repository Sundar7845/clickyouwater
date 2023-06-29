<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LogisticDriverInfo extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'logistic_partner_id',
        'hub_id',
        'logistic_vehicle_id',
        'driver_name',
        'license_no',
        'license_doc_path',
        'license_expiry',
        'mobile_no',
        'password',
        'is_active',
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
