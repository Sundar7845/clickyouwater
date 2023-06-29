<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class LogisticsManufactureConfig extends Model
{
    use HasFactory;

    public $timestamps= false;
    
    protected $fillable = [
        'logistic_partner_id',
        'manufacture_id'
    ];

    
    public function manufacturer()
    {
        return $this->belongsTo(Manufacturer::class, 'manufacture_id', 'id');
    }
}
