<?php

namespace App\Services;

use App\Models\ReservationActivityLog;
use App\Models\Reservation;

use Auth;
use DataTables;

class ReservationActivityLogServices 
{
    public function updateLog($action, $description, $type, $reservation_id, $guest_id = null)
    {
        if ($action == 'create') {
            $title = 'New Reservation';
        } else if ($action == 'update') {
            $title = 'Reservation Update';
        }

        $reservation = Reservation::find($reservation_id);
        
        $data = [
            'title' => $title,
            'action' => $action,
            'description' => $description,
            'type' => $type,
            'reservation_id' => $reservation_id,
            'amount' => $reservation->amount,
            'reservation_period' => date('jS M Y H:i A', strtotime($reservation->start_dt)).' - '.date('jS M Y H:i A', strtotime($reservation->end_dt)),
            'vehicle_model' => $reservation->vehicles->model,
            'reservation_status' => $reservation->status,
        ];

        if ($type == 'manual'){
            Auth::check()? $data['user_id'] = auth()->user()->id : $data['guest_id'] = $guest_id;
        }
        ReservationActivityLog::create($data);
    }

    public function findAll($limit = null, $offset = null)
    {
        $reservationLog = ReservationActivityLog::query();

        if (!empty($offset)) {
            $reservationLog->skip($offset);
        }
        
        if (!empty($limit)) {
            $reservationLog->limit($limit);
        }
        return $reservationLog->orderBy('created_at', 'DESC')->get();
    }

    public function findById($id, $select = [])
    {
        $reservationLog = ReservationActivityLog::where('id', $id);
        if (count($select) > 0) {
            $reservationLog = $reservationLog->select($select);
        }
        return $reservationLog->first();
    }

    public function getIndexDataTable()
    {
        $data = ReservationActivityLog::orderBy('created_at', 'DESC')->get();
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('status', function($row) {
                if ($row->has_read) {
                    $status = '<span class="">Opened</span>';
                } else {
                    $status = '<span class="text-warning"><strong>New</strong></span>';
                }
                return $status;
            })
            ->addColumn('date_time', function($row) {
                return date("jS M Y, h:i A", strtotime($row->created_at));
            })
            ->addColumn('action', function($row) {
                $btn = '<div class="gap-8">
                        <button class="btn btn-ghost-gray btn-sm show-btn" data-bs-toggle="offcanvas"
                            data-bs-target="#offcanvasReservationLogShow"
                            aria-controls="offcanvasReservationLogShow" data-res_log_id="'.$row->id.'">
                            <i class="ic-show"></i>
                        </button>
                    </div>';
                return $btn;
            })
            ->rawColumns(['status','action'])
            ->make(true);
    }

    public function markAsRead($id)
    {
        $content = [
            'has_read' => 1
        ];
        ReservationActivityLog::where('id', $id)->update($content);
    }

    public function formatActivity($record)
    {
        $data = [
            'title' => $record->title,
            'description' => $record->description,
            'type' => $record->type,
            'performer' => $record->type == 'manual'? (!empty($record->user_id)? $record->users->first_name.' '.$record->users->last_name : $record->guest->full_name) : 'NA',
            'status' => $record->reservation_status,
            'code' => $record->reservation->reservation_code,
            'model' => $record->vehicle_model,
            'period' => $record->reservation_period,
            'amount' => '$'.$record->amount,
            'user' => !empty($record->reservation->is_guest)? ($record->reservation->guest->full_name) : ($record->reservation->users->first_name.' '.$record->reservation->users->last_name),
            'phone' => !empty($record->reservation->is_guest)? ($record->reservation->guest->mobile_number) : ($record->reservation->users->mobile_number),
            'email' => !empty($record->reservation->is_guest)? ($record->reservation->guest->email) : ($record->reservation->users->email)
        ];
        return $data;
    }
}