<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Services\VehicleServices;

class HomeTopVehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehicle1',
        'vehicle2'
    ];

    public function getVehicle($id)
    {
        $vehicle = new VehicleServices();
        $select = [
            'model',
            'images',
            'slug',
            'availability'
        ];
        $result = $vehicle->findVehicleById($id, $select);
        return $result;
    }
}
