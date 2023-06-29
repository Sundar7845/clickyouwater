<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ledger extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'ledger_code',
        'ledger_type_id',
        'ledger_name',
        'mobile',
        'street',
        'area_id',
        'city_id',
        'state_id',
        'pincode',
        'credit_period',
        'settlement_period',
        'opening_balance',
        'closing_balance',
        'credit_debit',
        'is_active',
        'created_by',
        'updated_by'
    ];

    protected $preventSoftDelete = true; // add this line
   
    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id', 'id');
    }
}
