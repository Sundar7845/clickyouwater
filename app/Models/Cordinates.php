<?php

namespace App\Models;

use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cordinates extends Model
{
    use HasFactory;
    use SpatialTrait;

    protected $spatialFields = [
        'geo_coordinates'
    ];

}
