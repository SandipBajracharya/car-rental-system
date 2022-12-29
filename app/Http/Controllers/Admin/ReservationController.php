<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ReservationServices;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ReservationController extends Controller
{
    private $reservationService;

    public function __construct(ReservationServices $service)
    {
        $this->reservationService = $service;
    }

    public function activeReservations(Request $request)
    {
        if ($request->ajax()) {
            return $this->reservationService->getActiveDataTable();
        }
        return view('pages.admin.reservation.activeReservations');
    }

    public function completedReservations(Request $request)
    {
        if ($request->ajax()) {
            return $this->reservationService->getCompletedDataTable();
        }
        return view('pages.admin.reservation.completedReservations');
    }

    public function cancelledReservations(Request $request)
    {
        if ($request->ajax()) {
            $pending = false;
            if (isset($request->pending) && $request->pending) {
                $pending = true;
            }
            return $this->reservationService->getCancelledDataTable($pending);
        }
        return view('pages.admin.reservation.cancelledReservations');
    }

    public function show($id)
    {
        $data = $this->reservationService->findReservationById($id);
        return $this->reservationService->formatModalData($data);
    }

    public function edit($id)
    {
        $data = $this->reservationService->findReservationById($id);
        $data = $this->reservationService->formatModalData($data);
        return $this->reservationService->formatModalShowData($data);
    }

    public function update(Request $request, $id)
    {
        $result = $this->reservationService->updateReservation($request, $id);
        Alert::toast($result['message'], $result['status']);
        return redirect()->back();
    }

    public function markCancelledAsRefunded($id)
    {
        $result = $this->reservationService->markCancelledReservationAsRefunded($id);
        Alert::toast($result['message'], $result['status']);
        return redirect()->back();
    }
}
