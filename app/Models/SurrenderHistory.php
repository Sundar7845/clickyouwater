<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurrenderHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'surrender_id',
        'status_id'
    ];

    public function status()
    {
        return $this->belongsTo(Status::class);
    }
}
