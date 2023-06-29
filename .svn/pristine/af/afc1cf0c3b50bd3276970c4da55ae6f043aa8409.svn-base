<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HubReturnItems extends Model
{
    use HasFactory;
    protected $fillable = [
        'hub_id',
        'driver_id',
        'status_id'
    ];

    public function hubReturnItemsDets()
    {
        return $this->hasMany(HubReturnItemsDet::class, 'hub_return_items_id');
    }
}
