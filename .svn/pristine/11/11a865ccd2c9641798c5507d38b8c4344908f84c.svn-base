<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class LogisticsHubConfig extends Model
{
    use HasFactory;

    public $timestamps= false;

    protected $fillable = [
        'logistic_partner_id',
        'hub_id'
    ];

    public function hub()
    {
        return $this->belongsTo(Hub::class, 'hub_id', 'id');
    }
}
