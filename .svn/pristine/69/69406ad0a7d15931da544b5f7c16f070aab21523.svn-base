<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerAddress extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'customer_id',
        'addresstype_id',
        'building_no',
        'street',
        'area',
        'landmark',
        'city_id',
        'state_id',
        'country_id',
        'pincode',
        'floor',
        'is_lift_avail_working',
        'contact_person_name',
        'contact_person_mobile',
        'latitude',
        'longitude',
        'geolocation',
        'is_service_available',
        'is_default',
        'is_manual_address',
        'created_by',
        'updated_by',
        'deleted_by'
    ];
    public function getAddressType()
    {
        return $this->belongsTo(AddressType::class, 'addresstype_id', 'id');
    }
    public function cityname()
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }
    public function statename()
    {
        return $this->belongsTo(State::class, 'state_id', 'id');
    }
    public function countryname()
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }
    public function orders()
    {
        return $this->hasMany(Order::class, 'delivery_address_id');
    }

    public function surrender()
    {
        return $this->hasMany(Surrender::class, 'address_id');
    }
}
