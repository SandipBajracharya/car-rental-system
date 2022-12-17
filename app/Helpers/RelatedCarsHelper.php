<?php

use App\Services\VehicleServices;

function getRelatedCars($id)          // get other cars expect of given id
{
    $vehicleService = new VehicleServices;
    $vehicles = $vehicleService->findAllVehicles($limit = 3, null, true);
    $vehicles = $vehicles->where('id', '!=', $id)
        ->select('model', 'slug', 'images', 'pricing', 'is_reserved_now')
        ->get();
    return $vehicles;
}