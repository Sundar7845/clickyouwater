<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LogisticPartner extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'logistic_partner_code',
        'logistic_partner_name',
        'years_of_experience',
        'mobile',
        'email',
        'credit_period',
        'settlement_period',
        'password',
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

    public static function boot()
    {
        parent::boot();

        static::bootSoftDeletes();
    }

    public static function bootSoftDeletes()
    {
        static::deleting(function ($logisticpartner) {
            
            if ($logisticpartner->logisticvehicleinfo()->count() > 0) {
                throw new \Exception('Cannot delete logistic partner name because there are associated logistic partners.');
            }
            if ($logisticpartner->logisticdriverinfo()->count() > 0) {
                throw new \Exception('Cannot delete logistic partner name type because there are associated logistic partners.');
            }
          
        });
        static::restoring(function ($logisticpartner) {
            // add any restoring logic here if necessary
        });
    }

    public function logisticvehicleinfo()
    {
        return $this->hasMany(LogisticVehicleInfo::class);
    }

    public function logisticdriverinfo()
    {
        return $this->hasMany(LogisticDriverInfo::class);
    }
   
}
