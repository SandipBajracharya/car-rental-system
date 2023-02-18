<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\GuestInfoRequest;
use App\Http\Requests\VehicleSearchRequest;
use App\Services\ReservationServices;
Use App\Helpers\EmailHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class ReservationController extends Controller
{
    private $reservationService;

    public function __construct(ReservationServices $service)
    {
        $this->reservationService = $service;
    }

    public function findCar(VehicleSearchRequest $request)  
    {
        $inputs = $request->all();
        $inputs['pickup_location'] = $request->pickup_location;
        $inputs['start_dt'] = date('Y-m-d H:i:s', strtotime(str_replace('T', ' ', $request->start_dt)));
        $inputs['end_dt'] = date('Y-m-d H:i:s', strtotime(str_replace('T', ' ', $request->end_dt)));
        session()->put('rental_info', $inputs);
        $vehicles = $this->reservationService->getAvailableCars($inputs);
        return view('pages.main.carListing', compact('vehicles', 'inputs'));
    }

    public function checkout(Request $request)
    {
        if (Auth::check()) {
            session()->put('vehicle_id', $request->vehicle_id);
            session()->forget('is_guest');
            $is_guest = false;
            // check userinfo for proper documents and redirect if not found
            if (Auth::user()->can_reserve || Auth::user()->role_id == 1) {           //additional requirement for super admin
                return view('pages.main.carCheckout', compact('is_guest'));
            } else {
                Alert::toast('Please complete your profile first!', 'info');
                return redirect('/profile-setting');
            }
        } else {
            return redirect('/login');
        }
    }

    public function checkoutAsGuest(Request $request)
    {
        session()->put('vehicle_id', $request->vehicle_id);
        session()->put('is_guest', true);
        $is_guest = true;
        return view('pages.main.carCheckout', compact('is_guest'));
    }

    public function processCarReservation(Request $request)
    {
        $reserve_info = session()->get('rental_info');
        $vehicle_id = session()->get('vehicle_id');

        if (isset($reserve_info) && isset($vehicle_id)) {
            // $is_guest = session()->get('is_guest');

            if (Auth::check()) {
                $resp = $this->reservationService->storeReservation($vehicle_id, $reserve_info);

                // send email to client
                $email_data = ['email' => auth()->user()->email, 'name' => auth()->user()->first_name.' '.auth()->user()->last_name, 'process' => 'active', 'order'=> $resp['data']];
                EmailHelper::emailSend($email_data);

                Alert::toast($resp['message'], $resp['status']);
                return redirect()->back();
            } else {
                session()->forget('rental_info');
                session()->forget('vehicle_id');
                session()->forget('is_guest');
                return redirect()->back()->withInput();
            }
        } else {
            session()->forget('rental_info');
            session()->forget('vehicle_id');
            session()->forget('is_guest');
            return redirect('/car-listing');
        }
    }

    public function checkVehicleAvailability(Request $request, $vehicle_id)
    {
        $inputs = $request->all();
        $inputs['pickup_location'] = $request->pickup_location;
        $inputs['start_dt'] = date('Y-m-d H:i:s', strtotime(str_replace('T', ' ', $request->start_dt)));
        $inputs['end_dt'] = date('Y-m-d H:i:s', strtotime(str_replace('T', ' ', $request->end_dt)));
        session()->put('rental_info', $inputs);
        $isAvailable = $this->reservationService->checkVehicleAvailability($inputs, $vehicle_id);
        return $isAvailable;
    }
}
