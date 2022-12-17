<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

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
        'is_guest'
    ];
}
