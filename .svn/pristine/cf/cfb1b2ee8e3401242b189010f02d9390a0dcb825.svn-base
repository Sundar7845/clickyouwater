<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationType extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'notification_type'
    ];

    public function notifications()
    {
        return $this->hasMany(UserNotifications::class, 'notification_type_id');
    }
}
