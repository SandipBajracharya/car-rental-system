<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\HomePageServices;
use App\Services\VehicleServices;

class MainController extends Controller
{
    private $homePageService, $vehicleService;

    public function __construct(HomePageServices $service, VehicleServices $vehicleService)
    {
        $this->homePageService = $service;
        $this->vehicleService = $vehicleService;
    }

    public function index()
    {
        $home_sliders = $this->homePageService->findAllHomeSliders();
        $topVehicle = $this->homePageService->findTopVehicle();
        return view('pages.main.homePage', compact(['home_sliders', 'topVehicle']));
    }

    public function carListing()
    {
        $vehicles = $this->vehicleService->findAllVehicles();
        $inputs = session()->get('rental_info') ?? [];
        return view('pages.main.carListing', compact('vehicles', 'inputs'));
    }

    public function viewCarDetail(Request $request, $slug)
    {
        if (isset($request->rent)) {
            session()->forget('rental_info');
        }
        $vehicle = $this->vehicleService->findVehicleBySlug($slug);
        empty($vehicle->features)? $features = [] : $features = explode(',', $vehicle->features);
        $rental_info = session()->get('rental_info') ?? [];
        $show_filter = isset($rental_info) && count($rental_info) > 0? false : true;
        return view('pages.main.carDetail', compact('vehicle', 'show_filter', 'rental_info', 'features'));
    }

    public function ajaxCarDetail(Request $request)
    {
        $id = $request->id;
        $vehicle = $this->vehicleService->findVehicleById($id);
        $rental_info = session()->get('rental_info') ?? [];
        $show_filter = isset($rental_info) && count($rental_info) > 0? false : true;
        $carDetail = view('include.main.carDetailModal', ['vehicle' => $vehicle, 'show_filter' => $show_filter, 'rental_info' => $rental_info])->render();
        return compact('carDetail');
    }
}
