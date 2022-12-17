<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\HomeSliderRequest;
use App\Services\HomePageServices;
use App\Services\VehicleServices;

use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

use Session;

class HomePageController extends Controller
{
    private $homePageService, $vehicleService;

    public function __construct(HomePageServices $service, VehicleServices $vehicleService)
    {
        $this->homePageService = $service;
        $this->vehicleService = $vehicleService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->homePageService->getIndexDataTable();
        }
        $vehicles = $this->vehicleService->findAllVehicles();
        $topVehicle = $this->homePageService->findTopVehicle();
        return view('pages.admin.landingCms.index', compact(['vehicles', 'topVehicle']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(HomeSliderRequest $request)
    {
        $result = $this->homePageService->addHomeSlider($request);
        Alert::toast($result['message'], $result['status']);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = $this->homePageService->findSliderContentById($id);
        return $data;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = $this->homePageService->findSliderContentById($id);
        return $data;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(HomeSliderRequest $request, $id)
    {
        $result = $this->homePageService->updateHomeSlider($request, $id);
        Alert::toast($result['message'], $result['status']);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = $this->homePageService->deleteHomeSlider($id);
        Alert::toast($result['message'], $result['status']);
        return redirect()->back();
    }

    // public function updateAvailability(Request $request, $id)
    // {
    //     $req = $request->all();
    //     $result = $this->homePageService->updateAvailableStatus($req, $id);
    //     return $result;
    // }

    public function updateHomeTopVehicles(Request $request)
    {
        $params = $request->all();
        $result = $this->homePageService->updateHomeTopVehicles($params);
        Alert::toast($result['message'], $result['status']);
        return redirect()->back();
    }
}
