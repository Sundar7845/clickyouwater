<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleBrand extends Model
{
    use HasFactory;

    protected $fillable = [
        'fuel_type_id',
        'brand_name',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    
    // public static function boot()
    // {
    //     parent::boot();

    //     static::bootSoftDeletes();
    // }

    // public static function bootSoftDeletes()
    // {
    //     static::deleting(function ($vehiclebrand) {
           
    //         if ($vehiclebrand->hubvehicleinfo()->count() > 0) {
    //             throw new \Exception('Cannot delete hub type because there are associated hub.');
    //         }
            
    //     });
    //     static::restoring(function ($vehiclebrand) {
    //         // add any restoring logic here if necessary
    //     });
    // }

    // public function hubvehicleinfo()
    // {
    //     return $this->hasMany(HubVehicleInfo::class);
    // }
}
