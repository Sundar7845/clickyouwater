<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'status',
        'status_msg'
    ];


    public function orders()
    {
        return $this->hasMany(Order::class, 'status_id');
    }

    public function orderDets()
    {
        return $this->hasMany(OrderDet::class, 'status_id');
    }

    public function userOrderHistories()
    {
        return $this->hasMany(UserOrderHistory::class, 'status_id');
    }

    public function orderTrackings()
    {
        return $this->hasMany(OrderTracking::class, 'status_id');
    }

    public function surrender()
    {
        return $this->hasMany(Surrender::class, 'status_id');
    }

    public function surrenderDets()
    {
        return $this->hasMany(SurrenderDet::class, 'status_id');
    }
    public function surrenderHistory()
    {
        return $this->hasMany(SurrenderHistory::class, 'status_id');
    }
}
