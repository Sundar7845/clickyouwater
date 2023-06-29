<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brands extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'brand_name',
        'brand_image',
        'product_type_id',
        'is_active',
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
    static::deleting(function ($brands) {
        $brandIds = explode(',', $brands->getKey()); // Split the brand_ids into an array
        $brandIds = array_map('intval', $brandIds); // Convert the brand_ids array elements to integers

        $affectedRows = StateBrandAllocation::whereIn('brand_id', $brandIds)->count();
        
        if ($affectedRows > 0) {
            throw new \Exception('Cannot delete Brand type because it is associated with StateBrandAllocations.');
        }

        $productCount = $brands->products()->whereIn('brand_id', $brandIds)->count();
        
        if ($productCount > 0) {
            throw new \Exception('Cannot delete brand type because there are associated products.');
        }
    });

    static::restoring(function ($brands) {
        // add any restoring logic here if necessary
    });
}

public function brandallocations()
{
    return $this->hasMany(StateBrandAllocation::class, 'brand_id');
}

public function products()
{
    return $this->hasMany(Products::class, 'brand_id');
}
}
