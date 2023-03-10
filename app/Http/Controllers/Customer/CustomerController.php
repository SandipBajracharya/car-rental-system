<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Services\ReservationServices;
use Illuminate\Http\Request;

Use Auth;
use RealRashid\SweetAlert\Facades\Alert;

class CustomerController extends Controller
{
    private $reservationService;

    public function __construct(ReservationServices $reservationService)
    {
        $this->reservationService = $reservationService;
    }

    public function showCustomerHistory()
    {
        $reservations = $this->reservationService->getReservationsByUserId(Auth::user()->id);
        return view('pages.customer.history.bookingHistory', compact('reservations'));
    }

    // ajax call
    public function show($id)
    {
        $data = $this->reservationService->findReservationById($id);
        return $this->reservationService->formatModalData($data);
    }

    public function cancelReservation(Request $request)
    {
        $resp = $this->reservationService->manualCancelReservation($request->id);
        Alert::toast($resp['message'], $resp['status']);
        return redirect()->back();
    }
}
