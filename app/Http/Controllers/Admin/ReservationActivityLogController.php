<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ReservationActivityLogServices;
use Illuminate\Http\Request;

class ReservationActivityLogController extends Controller
{
    private $reservationLogService;

    public function __construct(ReservationActivityLogServices $reservation)
    {
        $this->reservationLogService = $reservation;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->reservationLogService->getIndexDataTable();
        }
        return view('pages.admin.reservationLog.index');
    }

    public function show($id)
    {
        $record = $this->reservationLogService->findById($id);
        $record = $this->reservationLogService->formatActivity($record);
        $this->reservationLogService->markAsRead($id);
        return $record;
    }
}
