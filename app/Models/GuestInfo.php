<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuestInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'email',
        'country',
        'state',
        'city',
        'street',
        'postal_code',
        'dob',
        'reservation_id',
        'document_image',
        'document_type',
        'document_number',
        'document_country',
        'document_expire',
        'notes',
    ];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class, 'reservation_id', 'id');
    }

    public function reservationLog()
    {
        return $this->hasMany(ReservationActivityLog::class, 'guest_id');
    }
}
