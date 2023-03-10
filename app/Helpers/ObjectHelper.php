<?php

namespace App\Helpers;

use App\Services\VehicleServices;
use App\Services\ReservationServices;
use App\Services\ReservationActivityLogServices;

class ObjectHelper
{
    public static function getVehicleServiceObject()
    {
        return new VehicleServices;
    }

    public static function getReservationServiceObject()
    {
        return new ReservationServices;
    }

    public static function getReservationActivityObject()
    {
        return new ReservationActivityLogServices;
    }
}