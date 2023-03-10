<?php

use App\Helpers\ObjectHelper;

function getRelatedCars($id)          // get other cars expect of given id
{
    $rental_info = session()->get('rental_info') ?? [];
    if (count($rental_info) > 0) {
        $vehicles = ObjectHelper::getReservationServiceObject()->getAvailableCars($rental_info, 3);
    } else {
        $vehicles = ObjectHelper::getVehicleServiceObject()->findAllVehicles($limit = 3, null, true);
        $vehicles = $vehicles->where('id', '!=', $id)
            ->select('model', 'slug', 'images', 'pricing', 'is_reserved_now')
            ->get();
    }
    return $vehicles;
}