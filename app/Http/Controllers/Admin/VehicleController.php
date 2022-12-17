<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\VehicleRequest;
use App\Services\VehicleServices;

use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

use Session;

class VehicleController extends Controller
{
    private $vehicleService;

    public function __construct(VehicleServices $service)
    {
        $this->vehicleService = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->vehicleService->getIndexDataTable();
        }
        return view('pages.admin.vehicle.index');
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
    public function store(VehicleRequest $request)
    {
        $result = $this->vehicleService->addVehicle($request);
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
        $data = $this->vehicleService->findVehicleById($id);
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
        $data = $this->vehicleService->findVehicleById($id);
        return $data;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(VehicleRequest $request, $id)
    {
        $result = $this->vehicleService->updateVehicle($request, $id);
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
        $result = $this->vehicleService->deleteVehicle($id);
        Alert::toast($result['message'], $result['status']);
        return redirect()->back();
    }

    public function updateAvailability(Request $request, $id)
    {
        $req = $request->all();
        $result = $this->vehicleService->updateAvailableStatus($req, $id);
        return $result;
    }
}
