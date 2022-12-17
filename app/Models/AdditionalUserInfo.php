<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdditionalUserInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'document_image',
        'document_type',
        'document_number',
        'dob'
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'user_id', 'id');
    }
}
