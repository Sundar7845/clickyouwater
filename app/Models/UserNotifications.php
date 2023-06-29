<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserNotifications extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'notification_msg',
        'notification_type_id',
        'notified_on',
        'is_viewed'
    ];

    public function notification_type()
    {
        return $this->belongsTo(NotificationType::class);
    }
}
