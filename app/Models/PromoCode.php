<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PromoCode extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'promo_name',
        'promo_code',
        'discount_percentage',
        'max_discount',
        'status',
        'created_by',
        'updated_by'
    ];
}
