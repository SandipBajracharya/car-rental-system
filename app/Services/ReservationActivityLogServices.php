<?php

namespace App\Services;

use App\Models\ReservationActivityLog;

use Auth;
use DataTables;

class ReservationActivityLogServices 
{
    public function updateLog($action, $description, $type, $reservation_id, $guest_id = null)
    {
        if ($action == 'create') {
            $title = 'New Reservation Made';
        } else if ($action == 'update') {
            $title = 'Reservation Update';
        }
        
        $data = [
            'title' => $title,
            'action' => $action,
            'description' => $description,
            'type' => $type,
            'reservation_id' => $reservation_id
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
                        <button
                            class="btn btn-ghost-gray btn-sm mark-read-btn" data-bs-toggle="modal"
                            data-bs-target="#offcanvasReservationLogMarkRead" 
                            aria-controls="offcanvasReservationLogMarkRead" data-res_log_id="'.$row->id.'">
                            <i class="ic-edit"></i>
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
}