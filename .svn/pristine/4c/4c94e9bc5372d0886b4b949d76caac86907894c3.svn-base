<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Asset extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'asset_id',
        'asset_type_id',
        'asset_name',
        'asset_detail',
        'created_by',
        'updated_by',
        'deleted_by'
    ];
    protected $preventSoftDelete = true; // add this line

    public function assetType()
    {
        return $this->belongsTo(AssetType::class, 'asset_type_id', 'id');
    }


    protected $dates = ['deleted_at'];

    public static function boot()
    {
        parent::boot();

        static::bootSoftDeletes();
    }

    public static function bootSoftDeletes()
    {
        static::deleting(function ($asset) {
            
            if ($asset->employeesasset()->count() > 0) {
                throw new \Exception('Cannot delete ledger type because there are associated ledgers.');
            }
           
        });
        static::restoring(function ($asset) {
            // add any restoring logic here if necessary
        });
    }

    public function employeesasset()
    {
        return $this->hasMany(EmployeeAssets::class);
    }
}
