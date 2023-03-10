<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'reservation_code',
        'vehicle_id',
        'user_id',
        'start_dt',
        'end_dt',
        'is_reserved',
        'Status (active, canceled, completed)',
        'amount',
        'pickup_location',
        'drop-off_location',
        'payment_mode',
        'payment_id',
        'is_guest',
        'note',
        'has_refunded',
        'start_cron',
        'end_cron',
        'cron_last_execution',
        'payment_gateway'
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function vehicles()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id', 'id');
    }

    public function guest()
    {
        return $this->hasOne(GuestInfo::class, 'reservation_id');
    }

    public function reservationLog()
    {
        return $this->hasMany(ReservationActivityLog::class, 'reservation_id');
    }
}
