<?php

namespace App\Services;

Use App\Helpers\EmailHelper;
use App\Models\Reservation;
use App\Models\Vehicle;
use App\Models\AdditionalUserInfo;
use App\Models\GuestInfo;
use App\Services\VehicleServices;
use App\Services\ReservationActivityLogServices;
use Illuminate\Database\Eloquent\Model;

use Auth;
use DataTables;
use Carbon\Carbon;

class ReservationServices extends Model
{
    private $vehicleService, $reservationLogService;

    public function __construct(VehicleServices $vehicle, ReservationActivityLogServices $reservation)
    {
        $this->vehicleService = $vehicle;
        $this->reservationLogService = $reservation;
    }

    public function findReservationById($id, $select = [])
    {
        $reservation = Reservation::where('id', $id);
        if (count($select) > 0) {
            $reservation = $reservation->select($select);
        }
        return $reservation->first();
    }

    public function getAvailableCars($inputs)
    {
        $vehicles = $this->reservationCheckLogic($inputs);

        // get vehicles which are not reserved
        return Vehicle::where('availability', 1)
            ->whereNotIn('id', $vehicles)
            ->orderBy('created_at', 'DESC')
            ->get();
    }

    public function checkVehicleAvailability($inputs, $vehicle_id)
    {
        $vehicles = $this->reservationCheckLogic($inputs);

        if (!in_array($vehicle_id, $vehicles)) {
            return true;
        } else {
            return false;
        }
    }

    private function reservationCheckLogic($inputs)
    {
        $reserved_vehicles = Reservation::query();
        if (isset($inputs['start_dt']) && isset($inputs['end_dt'])) {
            $start_date = $inputs['start_dt'];
            $end_date = $inputs['end_dt'];
            $vehicles = $reserved_vehicles->where(function ($query) use ($start_date, $end_date) {
                    $query->whereRaw("? BETWEEN start_dt AND end_dt", [$start_date])
                        ->whereRaw("? BETWEEN start_dt AND end_dt", [$end_date]);
                })
                ->orWhere(function ($que) use ($start_date, $end_date) {
                    $que->whereRaw('? BETWEEN start_dt AND end_dt', [$start_date])
                        ->where('end_dt', '<=', $end_date);
                })
                ->orWhere(function ($q) use ($start_date, $end_date) {
                    $q->whereRaw("? BETWEEN start_dt AND end_dt", [$end_date])
                        ->where('start_dt', '>=', $start_date);
                })
                ->orWhere(function ($new_que) use ($start_date, $end_date) {
                    $new_que->where('start_dt', '>=', $start_date)
                        ->where('end_dt', '<=', $end_date);
                })
                ->orWhere(function ($query) use ($inputs) {
                    $query->where('start_dt', '=', $inputs['start_dt'])
                        ->orWhere('end_dt', '=', $inputs['start_dt']);
                })
                ->orWhere(function ($query) use ($inputs) {
                    $query->where('start_dt', '=', $inputs['end_dt'])
                        ->orWhere('end_dt', '=', $inputs['end_dt']);
                })
                ->distinct('vehicle_id')->pluck('vehicle_id')->toArray();
        } else if (isset($inputs['start_dt'])) {
            $vehicles = $reserved_vehicles->where(function ($query) use ($inputs) {
                    $query->where('start_dt', '=', $inputs['start_dt'])
                        ->orWhere('end_dt', '=', $inputs['start_dt']);
                })
                ->distinct('vehicle_id')->pluck('vehicle_id')->toArray();
        } else if (isset($inputs['end_dt'])) {
            $vehicles = $reserved_vehicles->where(function ($query) use ($inputs) {
                    $query->where('start_dt', '=', $inputs['end_dt'])
                        ->orWhere('end_dt', '=', $inputs['end_dt']);
                })
                ->distinct('vehicle_id')->pluck('vehicle_id')->toArray();
        } else {
            $vehicles = [];
        }

        return $vehicles;
    }

    public function checkAdditionalUserInfo($userid)
    {
        return AdditionalUserInfo::where('user_id', $userid)->count() > 0;
    }

    public function getAmount($vehicle_id, $reserve_info)
    {
        // get vehicle
        $vehicle_pricing = $this->vehicleService->findVehicleById($vehicle_id, ['pricing']);

        // calculate amount
        $date1 = date_create($reserve_info['start_dt']);
        $date2=date_create($reserve_info['end_dt']);
        $diff=date_diff($date1,$date2);
        if ($diff->format("%a") < 1) {
            $amount = $vehicle_pricing->pricing;
        } else {
            $amount = $diff->format("%a") * $vehicle_pricing->pricing;
        }

        return $amount;
    }

    public function storeReservation($vehicle_id, $reserve_info)
    {
        $is_reserved = 0;
        $current_time = date('Y-m-d H:i:s');
        if ($current_time == $reserve_info['start_dt']) {
            $is_reserved = 1;
        }

        // Reservation code
        $code = $this->getReservationCode();

        // get amount
        $amount = $this->getAmount($vehicle_id, $reserve_info);

        // cron for schedular
        $start_cron = $this->generateCronExpression($reserve_info['start_dt']);
        $end_cron = $this->generateCronExpression($reserve_info['end_dt']);

        try {
            $payload = [
                'vehicle_id' => $vehicle_id,
                'start_dt' => $reserve_info['start_dt'],
                'end_dt' => $reserve_info['end_dt'],
                'start_cron' => $start_cron,
                'end_cron' => $end_cron,
                'pickup_location' => $reserve_info['pickup_location'],
                'reservation_code' => $code,
                'is_reserved' => $is_reserved,
                'amount' => $amount,
            ];
    
            if (Auth::check()) {
                $payload['user_id'] = auth()->user()->id;
                $desp = 'Reservation has been made.';
            } else {
                $payload['is_guest'] = 1;
            }
            $reservation_info = Reservation::create($payload);
            Auth::check()? $this->reservationLogService->updateLog('create', $desp, 'manual', $reservation_info->id) : false;           // reservation log update
            return ['status' => 'success', 'message' => 'Reservation done', 'data' => $reservation_info];
        } catch (\Throwable $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function getReservationCode()
    {
        $count = str_pad(Reservation::count(), 7,"0", STR_PAD_LEFT);
        $code = 'ECR#'.$count;
        return $code;
    }

    public function storeGuestInfo($inputs, $data)
    {
        if ($inputs->hasFile('document_image')) {
            $FilenameWithExtension = $inputs['document_image']->getClientOriginalName();
            $Filename = pathinfo($FilenameWithExtension, PATHINFO_FILENAME);
            $ext = $inputs['document_image']->getClientOriginalExtension();
            $name = $Filename.'_'.time().'.'.$ext;
            $inputs['document_image']->move(public_path().'/images/userDocument/', $name);  
            $filenamesToStore = $name;
        }

        $payload = [
            'full_name' => $inputs->full_name,
            'email' => $inputs->email,
            'country' => $inputs->country,
            'state' => $inputs->state,
            'city' => $inputs->city,
            'street' => $inputs->street,
            'postal_code' => $inputs->postal_code,
            'dob' => $inputs->dob,
            'document_number' => $inputs->document_number,
            'document_type' => $inputs->document_type,
            'document_country' => $inputs->document_country,
            'document_expire' => $inputs->document_expire,
            'document_image' => $filenamesToStore,
            'notes' => $inputs->notes,
            'reservation_id' => $data->id
        ];

        try {
            $guest = GuestInfo::create($payload);
            $desp = 'Reservation has been made.';
            $this->reservationLogService->updateLog('create', $desp, 'manual', $data->id, $guest->id);
            return ['status' => 'success', 'message' => 'Reservation is complete.'];
        } catch (\Throwable $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function getActiveDataTable()
    {
        $data = Reservation::where('status', 'Active')->orderBy('created_at', 'DESC')->get();
        $datatable = $this->reservationDatatable($data);
        return $datatable->addColumn('action', function($row) {
                $btn = '<div class="gap-8">
                        <button class="btn btn-ghost-gray btn-sm show_btn"
                            data-bs-toggle="offcanvas" data-bs-target="#offcanvasReservationDetail"
                            aria-controls="offcanvasReservationDetail" data-reservation_id="'.$row->id.'">
                            <i class="ic-show"></i>
                        </button>
                        <button class="btn btn-ghost-gray btn-sm edit_btn" data-bs-toggle="offcanvas"
                            data-bs-target="#offcanvasReservationEdit"
                            aria-controls="offcanvasReservationEdit" data-reservation_id="'.$row->id.'">
                            <i class="ic-edit"></i>
                        </button>
                    </div>';
                return $btn;
            })
            ->rawColumns(['action', 'amount'])
            ->make(true);
    }

    public function getCompletedDataTable()
    {
        $data = Reservation::where('status', 'Completed')->orderBy('created_at', 'DESC')->get();
        $datatable = $this->reservationDatatable($data);
        return $datatable->addColumn('action', function($row) {
                $btn = '<div class="gap-8">
                        <button class="btn btn-ghost-gray btn-sm show_btn"
                            data-bs-toggle="offcanvas" data-bs-target="#offcanvasReservationDetail"
                            aria-controls="offcanvasReservationDetail" data-reservation_id="'.$row->id.'">
                            <i class="ic-show"></i>
                        </button>
                    </div>';
                return $btn;
            })
            ->rawColumns(['action', 'amount'])
            ->make(true);
    }

    public function getCancelledDataTable($pending)
    {
        if ($pending) {
            $data = Reservation::where('status', 'Canceled')->where('has_refunded', 0)->orderBy('created_at', 'DESC')->get();
        } else {
            $data = Reservation::where('status', 'Canceled')->where('has_refunded', 1)->orderBy('created_at', 'DESC')->get();
        }
        $datatable = $this->reservationDatatable($data);
        return $datatable->addColumn('action', function($row) {
                $btn = '<div class="gap-8">
                        <button class="btn btn-ghost-gray btn-sm show_btn"
                            data-bs-toggle="offcanvas" data-bs-target="#offcanvasReservationDetail"
                            aria-controls="offcanvasReservationDetail" data-reservation_id="'.$row->id.'">
                            <i class="ic-show"></i>
                        </button>
                    </div>';
                return $btn;
            })
            ->rawColumns(['action', 'amount'])
            ->make(true);
    }

    public function formatModalData($row)
    {
        return [
            'initials' => !$row->is_guest? (isset($row->users)? ($row->users->initials) : 'C') : 'G',
            'client' => !$row->is_guest? (isset($row->users)? ($row->users->first_name .' '.$row->users->last_name) : null) : (isset($row->guest)? $row->guest->full_name : '-'),
            'phone_number' => !$row->is_guest? (isset($row->users)? $row->users->mobile_number : null) : (isset($row->guest)? $row->guest->mobile_number : null),
            'reservation_period' => date('H:i A jS M Y', strtotime($row->start_dt)) .' - '. date('H:i A jS M Y', strtotime($row->end_dt)),
            'vehicle_id' => $row->vehicle_id,
            'vehicle' => isset($row->vehicles)? $row->vehicles->model : null,
            'document_number' => !$row->is_guest? (isset($row->users)? $row->users->profile->document_number : null) : (isset($row->guest)? $row->guest->document_number : '-'),
            'payment_mode' => 'NA',
            'amount' => $row->amount,
            'email' => !$row->is_guest? (isset($row->users)? $row->users->email : null) : (isset($row->guest)? $row->guest->email : '-'),
            'pickup_location' => $row->pickup_location,
            'start_dt' => date('Y-m-d H:i:s', strtotime($row->start_dt)),
            'end_dt' => date('Y-m-d H:i:s', strtotime($row->end_dt))
        ];
    }

    public function formatModalShowData($data)
    {
        $inputs['pickup_location'] = $data['pickup_location'];
        $inputs['start_dt'] = $data['start_dt'];
        $inputs['end_dt'] = $data['end_dt'];
        $data['vehicles'] = $this->getAvailableCars($inputs);
        return $data;
    }

    public function updateReservation($request, $id)
    {
        $payload = [
            'vehicle_id' => $request->vehicle_id,
            'status' => $request->status
        ];

        try {
            $reservation = Reservation::find($id);
            if ($reservation->status != $request->status) {
                $desp = 'Reservation status has been updated to '.$request->status;
                $guest = GuestInfo::where('reservation_id', $id)->first();
                if (!empty($guest)) {
                    $operator = $guest->id;
                    $email_data = ['email' => $guest->email, 'name' => $guest->full_name, 'process' => $request->status, 'order'=> $reservation];
                } else {
                    $operator = null;
                    $email_data = ['email' => $reservation->users->email, 'name' => $reservation->users->first_name.' '.$reservation->users->last_name, 'process' => $request->status, 'order'=> $reservation];
                }
                EmailHelper::emailSend($email_data);
                $this->reservationLogService->updateLog('update', $desp, 'manual', $id, $operator);
            }
            Reservation::whereId($id)->update($payload);
            $res = ['status' => 'success', 'message' => 'Reservation updated successfully'];
        } catch (\Throwable $e) {
            $res = ['status' => 'error', 'message' => $e->getMessage()];
        }
        return $res;
    }

    public function reservationDatatable($data)
    {
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('client', function($row) {
                if (!empty($row->user_id)) {
                    return isset($row->users)? ($row->users->first_name .' '.$row->users->last_name) : null;
                } else {
                    if ($row->is_guest) {
                        return isset($row->guest)? $row->guest->full_name : null;
                    } else {
                        return null;
                    }
                }
            })
            ->addColumn('phone_number', function($row) {
                if (!empty($row->user_id)) {
                    return isset($row->users)? $row->users->mobile_number : null;
                } else {
                    if ($row->is_guest) {
                        return isset($row->guest)? $row->guest->mobile_number : null;
                    } else {
                        return null;
                    }
                }
            })
            ->addColumn('vehicle', function($row) {
                return isset($row->vehicles)? $row->vehicles->model : null;
            })
            ->addColumn('reservation_period', function($row) {
                return (date('H:i A jS M Y', strtotime($row->start_dt)) .' - '. date('H:i A jS M Y', strtotime($row->end_dt)));
            })
            ->addColumn('amount', function($row) {
                $amt = '<span class="fw-semibold text-success">$'.$row->amount.'</span>';
                return $amt;
            })
            ->addColumn('refund_type', function($row) {
                return "NA";
            });
    }

    public function markCancelledReservationAsRefunded($id)
    {
        try {
            Reservation::whereId($id)->update(['has_refunded' => 1]);
            $res = ['status' => 'success', 'message' => 'Marked as refunded.'];
        } catch (\Throwable $e) {
            $res = ['status' => 'error', 'message' => $e->getMessage()];
        }
        return $res;
    }

    public function autoUpdateReservations($id)
    {
        try {
            $reservation = Reservation::find($id);
            $operator = null;

            if (!$reservation->is_reserved) {
                $desp = 'Vehicle is in reserved state.';
                $reservation->is_reserved = 1;
                $reservation->cron_last_execution = Carbon::now();
            } else {
                $desp = 'Vehicle available for reservation.';
                $reservation->is_reserved = 0;
                $reservation->status = 'Completed';
                $reservation->cron_last_execution = Carbon::now();

                $guest = GuestInfo::where('reservation_id', $id)->first();
                if (!empty($guest)) {
                    $email_data = ['email' => $guest->email, 'name' => $guest->full_name, 'process' => 'Completed', 'order'=> $reservation];
                } else {
                    $email_data = ['email' => $reservation->users->email, 'name' => $reservation->users->first_name.' '.$reservation->users->last_name, 'process' => 'Completed', 'order'=> $reservation];
                }
                // send mail
                // $email_data = ['email' => $reservation->users->email, 'name' => $reservation->users->first_name.' '.$reservation->users->last_name, 'process' => 'Completed', 'order'=> $reservation];
                EmailHelper::emailSend($email_data);
            }
            $reservation->save();
            $this->reservationLogService->updateLog('update', $desp, 'auto', $id, $operator);

            return ['status' => 'success', 'message' => 'success'];
        } catch (\Throwable $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function generateCronExpression($date)
    {
        $cron = date('i H d m *', strtotime($date));
        return $cron;
    }

    public function processPayment($resp, $request)
    {
        if ($request->pmt_gateway) {
            $paypal = new PaypalController();
            $response = $paypal->postPaymentWithpaypal($resp['data']);
            
        } else {
            // stripe code here
        }
    }
}
