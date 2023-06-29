<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HubManufactureConfig extends Model
{
    use HasFactory;

    protected $fillable = [
        'hub_id',
        'manufacturer_id',
        'distance'
    ];
   
    
    public function manufacturer()
    {
        return $this->belongsTo(Manufacturer::class, 'manufacturer_id', 'id');
    }
}
