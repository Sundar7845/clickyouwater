<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeAssets extends Model
{
    use HasFactory;

    public $timestamps= false;

    protected $fillable = [
        'employee_id',
        'asset_type_id',
        'asset_id',
        'issued_by',
        'authorised_by'
    ];

    public function asset()
    {
        return $this->belongsTo(Asset::class, 'asset_id', 'id');
    }
}
