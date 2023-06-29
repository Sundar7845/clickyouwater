<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeliveryPerson extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'delivery_people';
    protected $fillable = [
        'delivery_person_code',
        'delivery_person_name',
        'mobile',
        'email',
        'state_id',
        'city_id',
        'area_id',
        'address',
        'pincode',
        'hub_id',
        'password',
        'delivery_person_image',
        'is_active',
        'is_online',
        'checked_in',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

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
    public function hub()
    {
        return $this->belongsTo(Hub::class, 'hub_id', 'id');
    }
}
