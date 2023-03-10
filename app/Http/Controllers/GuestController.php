<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\PaypalController;
use App\Http\Requests\GuestInfoRequest;
Use App\Helpers\EmailHelper;
use App\Helpers\ObjectHelper;
use App\Models\GuestInfo;
use App\Services\ReservationServices;
use RealRashid\SweetAlert\Facades\Alert;

class GuestController extends Controller
{
    private $reservationService;

    public function __construct(ReservationServices $service)
    {
        $this->reservationService = $service;
    }

    public function storeGuestInfo(GuestInfoRequest $request)
    {
        $is_guest = session()->get('is_guest');

        if (isset($is_guest) && $is_guest) {
            $result = $this->reservationService->storeGuestInfo($request);
            session()->put('guest_id', $result['data']->id);
            return redirect('/payment-option');
        } else {
            clearSession();
            Alert::toast("Not a guest", 'error');
            return redirect('/car-listing');
        }
    }

    public function processCarReservationAsGuest(Request $request)
    {
        $reserve_info = session()->get('rental_info');
        $vehicle_id = session()->get('vehicle_id');
        $guest_id = session()->get('guest_id');

        if (!isset($request->terms)) {
            Alert::toast('Please agree to the Terms & Conditions to proceed forward', 'error');
            return redirect()->back();
        }

        if (isset($reserve_info) && count($reserve_info) > 0 && isset($vehicle_id)) {
            $is_guest = session()->get('is_guest');
            session()->put('payment_gateway', $request->payment);

            if (isset($is_guest) && $is_guest) {
                $vehicle = ObjectHelper::getVehicleServiceObject()->findVehicleById($vehicle_id, ['model']);
                
                // process payment first
                if ($request->payment == 'stripe') {
                    $guest = GuestInfo::find($guest_id);
                    $data = [
                        'description' => 'Vehicle reservation by user - '.$guest->full_name.' (GuestID: '.$guest->id.'). Vehicle model: '.$vehicle->model,
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
                        'note' => 'Vehicle reservation'
                    ];

                    $paypal = new PaypalController();
                    $response = $paypal->postPaymentWithpaypal($data);                    
                    return $response;
                }
            } else {
                clearSession();
                Alert::toast("Not a guest", 'error');
                return redirect('/car-listing');
            }
        } else {
            clearSession();
            Alert::toast("Reservation details not found.", 'error');
            return redirect('/car-listing');
        }
    }
}
