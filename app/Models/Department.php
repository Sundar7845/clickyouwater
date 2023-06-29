<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'department_name',
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
        static::deleting(function ($department) {
            if ($department->employees()->count() > 0) {
                throw new \Exception('Cannot delete employee type because there are associated employees.');
            }
        });

        static::restoring(function ($department) {
            // add any restoring logic here if necessary
        });
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}
