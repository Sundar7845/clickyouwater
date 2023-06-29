<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssetType extends Model
{
    use HasFactory, SoftDeletes;
    // use SoftDeletes;
    protected $fillable = [
        'asset_type',
        'prefix',
        'created_by',
        'updated_by',
        'deleted_by'
    ];


    protected $dates = ['deleted_at'];

    public static function boot()
    {
        parent::boot();

        static::bootSoftDeletes();
    }

    public static function bootSoftDeletes()
    {
        static::deleting(function ($assetType) {
            if ($assetType->assets()->count() > 0) {
                throw new \Exception('Cannot delete asset type because there are associated assets.');
            }
        });

        static::restoring(function ($assetType) {
            // add any restoring logic here if necessary
        });
    }

    public function assets()
    {
        return $this->hasMany(Asset::class);
    }
}
