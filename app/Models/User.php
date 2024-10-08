<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'initials',
        'gender',
        'email',
        'password',
        'social_id',
        'social_type',
        'role_id',
        'mobile_number',
        'image',
        'email_verified_at'
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

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    public function profile()
    {
        return $this->hasOne(AdditionalUserInfo::class, 'user_id');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'user_id');
    }

    public function reservationLog()
    {
        return $this->hasMany(ReservationActivityLog::class, 'user_id');
    }

    public function checkEmailVerified()
    {
        if (empty($this->email_verified_at)) {
            return false;
        } else {
            return true;
        }
    }
}
