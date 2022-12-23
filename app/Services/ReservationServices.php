<?php

namespace App\Services;

use App\Models\Reservation;
use App\Models\Vehicle;
use App\Models\AdditionalUserInfo;
use App\Models\GuestInfo;
use App\Services\VehicleServices;
use Auth;

class ReservationServices
{
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
        $vehicleService = new VehicleServices();
        $vehicle_pricing = $vehicleService->findVehicleById($vehicle_id, ['pricing']);

        // calculate amount
        $date1 = date_create($reserve_info['start_dt']);
        $date2=date_create($reserve_info['end_dt']);
        $diff=date_diff($date1,$date2);
        $amount = $diff->format("%a") * $vehicle_pricing->pricing;

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

        try {
            $payload = [
                'vehicle_id' => $vehicle_id,
                'start_dt' => $reserve_info['start_dt'],
                'end_dt' => $reserve_info['end_dt'],
                'pickup_location' => $reserve_info['pickup_location'],
                'reservation_code' => $code,
                'is_reserved' => $is_reserved,
                'amount' => $amount,
            ];
    
            if (Auth::check()) {
                $payload['user_id'] = auth()->user()->id;
            } else {
                $payload['is_guest'] = 1;
            }
            $reservation_info = Reservation::create($payload);
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
            GuestInfo::create($payload);
            return ['status' => 'success', 'message' => 'Reservation is complete.'];
        } catch (\Throwable $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
}
