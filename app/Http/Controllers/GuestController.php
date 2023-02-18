<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\GuestInfoRequest;
Use App\Helpers\EmailHelper;
use App\Services\ReservationServices;
use RealRashid\SweetAlert\Facades\Alert;

class GuestController extends Controller
{
    private $reservationService;

    public function __construct(ReservationServices $service)
    {
        $this->reservationService = $service;
    }

    public function processCarReservationAsGuest(GuestInfoRequest $request)
    {
        $reserve_info = session()->get('rental_info');
        $vehicle_id = session()->get('vehicle_id');

        if (isset($reserve_info) && isset($vehicle_id)) {
            $is_guest = session()->get('is_guest');

            if (isset($is_guest) && $is_guest) {
                $resp = $this->reservationService->storeReservation($vehicle_id, $reserve_info);
                if (isset($resp) && $resp['status'] == 'success') {
                    $result = $this->reservationService->storeGuestInfo($request, $resp['data']);

                    // send email to client
                    $email_data = ['email' => $request->email, 'name' => $request->full_name, 'process' => 'active', 'order'=> $resp['data']];
                    EmailHelper::emailSend($email_data);

                    Alert::toast($resp['message'], $resp['status']);
                    $redirect_path = 'find-car?pickup_location='.$reserve_info['pickup_location'].'&start_dt='.$reserve_info['start_dt'].'&end_dt='.$reserve_info['end_dt'];
                    return redirect($redirect_path);
                } else {
                    Alert::toast($resp['message'], 'error');
                    return redirect()->back();
                }
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
}
