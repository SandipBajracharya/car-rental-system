<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservationActivityLog extends Model
{
    use HasFactory;

    protected $table = 'reservation_activity_log';
    protected $fillable = [
        'title',
        'action',
        'description',
        'type',
        'user_id',
        'guest_id',
        'reservation_id'
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function guest()
    {
        return $this->belongsTo(GuestInfo::class, 'guest_id', 'id');
    }

    public function reservation()
    {
        return $this->belongsTo(Reservation::class, 'reservation_id', 'id');
    }
}
