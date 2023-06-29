<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'user_name',
        'ref_id',
        'email',
        'user_img_path',
        'password',
        'role_id',
        'display_name',
        'mobile',
        'mobile_verified_at',
        'is_active',
        'otp',
        'otp_expiry',
        'referral_code',
        'is_approved',
        'device_id',
        'closing_balance',
        'fcm_token',
        'wallet_points',
        'account_holder_name',
        'account_no',
        'ifsc_code',
        'bank_name',
        'branch_name',
        'last_login',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function surrender()
    {
        return $this->hasMany(Surrender::class, 'user_id');
    }

    public function surrenderPickups()
    {
        return $this->hasMany(SurrenderPickup::class, 'delivery_user_id');
    }

    public function carts()
    {
        return $this->hasMany(Cart::class, 'user_id');
    }
    public function referralHistory()
    {
        return $this->hasOne(UserReferralHistory::class, 'user_id', 'id');
    }

    public function userDeposits()
    {
        return $this->hasMany(UserDepositHistory::class, 'user_id', 'id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
