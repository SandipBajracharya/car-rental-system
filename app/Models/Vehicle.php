<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'description',
        'features',
        'model',
        'plate_number',
        'mileage',
        'fuel_volume',
        'occupancy',
        'pricing',
        'images',
        'slug',
        'is_reserved_now',
        'created_by',
        'updated_by'
    ];
}
