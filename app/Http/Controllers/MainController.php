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
        return view('pages.main.carListing', compact('vehicles'));
    }

    public function viewCarDetail($slug)
    {
        $vehicle = $this->vehicleService->findVehicleBySlug($slug);
        $rental_info = session()->get('rental_info');
        $show_filter = isset($rental_info) && count($rental_info) > 0? false : true;
        return view('pages.main.carDetail', compact('vehicle', 'show_filter'));
    }

    public function ajaxCarDetail(Request $request)
    {
        $id = $request->id;
        $vehicle = $this->vehicleService->findVehicleById($id);
        $carDetail = view('include.main.carDetailModal', ['vehicle' => $vehicle])->render();
        return compact('carDetail');
    }
}
