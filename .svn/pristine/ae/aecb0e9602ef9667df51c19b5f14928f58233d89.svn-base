<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Manufacturer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'manufacturer_code',
        'manufacturer_name',
        'mobile',
        'official_email',
        'latitude',
        'longtitude',
        'geo_location',
        'credit_period',
        'settlement_period',
        'years_of_experience',
        'no_of_brands',
        'annual_turn_over',
        'security_deposit',
        'is_thirdparty_tieup',
        'no_of_thirdparty_brands',
        'thirdparty_brand_name',
        'thirdparty_turnover',
        'total_turnover',
        'country_id',
        'state_id',
        'city_id',
        'area_id',
        'address',
        'pincode',
        'proprietor_name',
        'proprietor_mobile',
        'proprietor_email',
        'contact_person_name',
        'contact_person_mobile',
        'contact_person_email',
        'qr_code_image',
        'is_active',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $preventSoftDelete = true; // add this line

    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id', 'id');
    }

    public function state()
    {
        return $this->belongsTo(State::class, 'state_id', 'id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }

    protected $dates = ['deleted_at'];

    // public static function boot()
    // {
    //     parent::boot();

    //     static::bootSoftDeletes();
    // }

    // public static function bootSoftDeletes()
    // {
    //     static::deleting(function ($manufacturer) {

    //         if ($manufacturer->hubmanufacturerconfig()->count() > 0) {
    //             throw new \Exception('Cannot delete hub type because there are associated hub.');
    //         }
    //         if ($manufacturer->logisticmanufacturerconfig()->count() > 0) {
    //             throw new \Exception('Cannot delete hub type because there are associated hub.');
    //         }

    //     });

    //     static::restoring(function ($manufacturer) {
    //         // add any restoring logic here if necessary
    //     });
    // }

    public function hubmanufacturerconfig()
    {
        return $this->hasMany(HubManufactureConfig::class);
    }

    public function logisticmanufacturerconfig()
    {
        return $this->hasMany(LogisticsManufactureConfig::class, 'manufacture_id');
    }
}
