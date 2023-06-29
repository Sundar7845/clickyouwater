<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurrenderPickup extends Model
{
    use HasFactory;

    protected $fillable = [
        'surrender_id',
        'delivery_user_id',
        'notes'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function surrender()
    {
        return $this->belongsTo(Surrender::class);
    }

    public function surrenderDets()
    {
        return $this->belongsTo(Surrender::class);
    }
}
