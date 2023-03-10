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

use App\Helpers\ObjectHelper;
use App\Http\Controllers\PaypalController;
use App\Http\Controllers\StripeController;

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
        if (!empty(Auth::user()->profile)) {
            $vehicle_id = $request->vehicle_id;
            $reserve_info = session()->get('rental_info');

            if (!empty($reserve_info) && count($reserve_info) > 0) {
                session()->put('vehicle_id', $vehicle_id);
                session()->forget('is_guest');
                $is_guest = false;
                // check userinfo for proper documents and redirect if not found
                if (Auth::user()->can_reserve || Auth::user()->role_id == 1) {           //additional requirement for super admin
                    $total = $this->reservationService->getAmount($vehicle_id, $reserve_info);
                    return view('pages.main.carCheckout', compact('is_guest', 'total', 'reserve_info', 'vehicle_id'));
                } else {
                    Alert::toast('Please complete your profile first!', 'info');
                    return redirect('/profile-setting');
                }
            } else {
                return redirect('car-listing');
            }
        } else {
            return redirect('/profile-setting');
        }
    }

    public function checkoutAsGuest(Request $request)
    {
        $reserve_info = session()->get('rental_info');
        $vehicle_id = $request->vehicle_id;

        if (!empty($reserve_info) && count($reserve_info) > 0) {
            session()->put('vehicle_id', $vehicle_id);
            session()->put('is_guest', true);
            $is_guest = true;
            $total = $this->reservationService->getAmount($vehicle_id, $reserve_info);
            return view('pages.main.carCheckout', compact('is_guest', 'total', 'reserve_info', 'vehicle_id'));
        } else {
            return redirect('/car-listing');
        }
    }

    public function paymentOption(Request $request)
    {
        $reserve_info = session()->get('rental_info');
        $vehicle_id = session()->get('vehicle_id');

        if (!empty($reserve_info) && count($reserve_info) > 0) {
            $total = $this->reservationService->getAmount($vehicle_id, $reserve_info);
            return view('pages.main.paymentOption', compact('reserve_info', 'total', 'vehicle_id'));
        } else {
            return redirect('/car-listing');
        }
    }

    public function processCarReservation(Request $request)
    {
        $reserve_info = session()->get('rental_info');
        $vehicle_id = session()->get('vehicle_id');

        if (!isset($request->terms)) {
            Alert::toast('Please agree to the Terms & Conditions to proceed forward', 'error');
            return redirect()->back();
        }

        if (isset($reserve_info) && isset($vehicle_id)) {
            session()->put('payment_gateway', $request->payment);

            if (Auth::check()) {
                $vehicle = ObjectHelper::getVehicleServiceObject()->findVehicleById($vehicle_id, ['model']);
                
                // process payment first
                if ($request->payment == 'stripe') {
                    $data = [
                        'description' => 'Vehicle reservation by user - '.Auth::user()->first_name.' '.Auth::user()->last_name.' (UserID: '.Auth::user()->id.'). Vehicle model: '.$vehicle->model,
                        'stripeToken' => $request->stripeToken,
                        'amount' => $this->reservationService->getAmount($vehicle_id, $reserve_info)
                    ];

                    $stripe = new StripeController();
                    $resp = $stripe->saveStripePayment($data);
                    return $resp;
                } else if (strtolower($request->payment) == 'paypal') {
                    $data = [
                        'model' => $vehicle->model,
                        'amount' => $this->reservationService->getAmount($vehicle_id, $reserve_info),
                        'note' => 'Vehicle reservation.'
                    ];

                    $paypal = new PaypalController();
                    $response = $paypal->postPaymentWithpaypal($data);                    
                    return $response;
                }
            } else {
                clearSession();
                Alert::toast("Not logged in", 'error');
                return redirect('/car-listing');
            }
        } else {
            clearSession();
            Alert::toast("Reservation details not found.", 'error');
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
        !$isAvailable? session()->forget('rental_info') : false;
        return $isAvailable;
    }
}
