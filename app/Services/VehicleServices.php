<?php

namespace App\Services;

use App\Models\Vehicle;
use Auth;
use DataTables;
use App\Helpers\SlugHelper;

class VehicleServices
{
    public function findVehicleById($id, $select = [])
    {
        $vehicle = Vehicle::where('id', $id);
        if (count($select) > 0) {
            $vehicle = $vehicle->select($select);
        }
        return $vehicle->first();
    }

    public function findVehicleBySlug($slug, $select = [])
    {
        $vehicle = Vehicle::where('slug', $slug);
            // ->where('availability', 1);
        if (count($select) > 0) {
            $vehicle = $vehicle->select($select);
        }
        return $vehicle->first();
    }

    public function findAllVehicles($limit = null, $offset = null, $other_conditions = false)
    {
        $vehicles = Vehicle::orderBy('created_at', 'DESC')
            ->where('availability', 1);
        
        if (!empty($limit)) {
            $vehicles = $vehicles->limit($limit);
        }

        if (!empty($offset)) {
            $vehicles = $vehicles->offset($offset);
        }

        if (!$other_conditions) {
            $vehicles = $vehicles->get();
        }

        return $vehicles;
    }

    public function getIndexDataTable()
    {
        $data = Vehicle::orderBy('created_at', 'DESC')->get();
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('availability', function($row) {
                $btn = '<div class="form-check form-switch vehicle-available-switch" data-vehicle_id="'.$row->id.'">
                    <input class="form-check-input" type="checkbox" id="switch01"';
                $row->availability === 1? $btn .= 'checked' : false;
                $btn .= '/></div>';
                return $btn;
            })
            ->addColumn('action', function($row) {
                $btn = '<div class="gap-8">
                        <button class="btn btn-ghost-gray btn-sm show_btn"
                            data-bs-toggle="offcanvas" data-bs-target="#offcanvasVehicleDetail"
                            aria-controls="offcanvasVehicleDetail" data-vehicle_id="'.$row->id.'">
                            <i class="ic-show"></i>
                        </button>
                        <button class="btn btn-ghost-gray btn-sm edit_btn" data-bs-toggle="offcanvas"
                            data-bs-target="#offcanvasVehicleEdit"
                            aria-controls="offcanvasVehicleEdit" data-vehicle_id="'.$row->id.'">
                            <i class="ic-edit"></i>
                        </button>
                        <button
                            class="btn btn-ghost-gray btn-sm delete-btn" data-bs-toggle="modal"
                            data-bs-target="#confirmationModal" data-vehicle_id="'.$row->id.'">
                            <i class="ic-delete"></i>
                        </button>
                    </div>';
                return $btn;
            })
            ->rawColumns(['availability','action'])
            ->make(true);
    }
        
    public function addVehicle($inputs)
    {
        if ($inputs->hasFile('images')) {
            foreach ($inputs['images'] as $file) {
                $FilenameWithExtension = $file->getClientOriginalName();
                $Filename = pathinfo($FilenameWithExtension, PATHINFO_FILENAME);
                $ext = $file->getClientOriginalExtension();
                $name = $Filename.'_'.time().'.'.$ext;
                $file->move(public_path().'/images/vehicles/', $name);  
                $filenamesToStore[] = $name;
            }
        } else {
            $filenamesToStore = [];
        }

        $slug = SlugHelper::slugify($inputs['model']);
        $vehicle = [
            'description' => $inputs['description'],
            'features' => $inputs['features'],
            'model' => $inputs['model'],
            'plate_number' => $inputs['plate_number'],
            'mileage' => $inputs['mileage'],
            'fuel_volume' => $inputs['fuel_volume'],
            'occupancy' => $inputs['occupancy'],
            'images' => json_encode($filenamesToStore),
            'pricing' => $inputs['pricing'],
            'slug' => $slug,
            'is_reserved_now' => $inputs['is_reserved_now'],
            'created_by' => Auth::user()->id
        ];

        try {
            Vehicle::create($vehicle);
            $result = ['status' => 'success', 'message' => 'Vehicle added successfully.'];
        } catch (\Throwable $e) {
            $result = ['status' => 'error', 'message' => $e->getMessage()];
        }
        return $result;
    }

    public function updateVehicle($inputs, $id)
    {
        $vehicle = array();
        $image = array();
        if ($inputs->hasFile('images')) {
            $filenamesToStore = [];
            foreach ($inputs['images'] as $file) {
                $FilenameWithExtension = $file->getClientOriginalName();
                $Filename = pathinfo($FilenameWithExtension, PATHINFO_FILENAME);
                $ext = $file->getClientOriginalExtension();
                $name = $Filename.'_'.time().'.'.$ext;
                $file->move(public_path().'/images/vehicles/', $name);  
                $filenamesToStore[] = $name;
            }
            $image = ['images' => json_encode($filenamesToStore)];
        }

        $slug = SlugHelper::slugify($inputs['model']);
        $vehicle = [
            'description' => $inputs['description'],
            'features' => $inputs['features'],
            'model' => $inputs['model'],
            'plate_number' => $inputs['plate_number'],
            'mileage' => $inputs['mileage'],
            'fuel_volume' => $inputs['fuel_volume'],
            'occupancy' => $inputs['occupancy'],
            'pricing' => $inputs['pricing'],
            'slug' => $slug,
            'is_reserved_now' => $inputs['is_reserved_now'],
            'updated_by' => Auth::user()->id
        ];
        $vehicle = array_merge($vehicle, $image);

        try {
            Vehicle::where('id', $id)->update($vehicle);
            $result = ['status' => 'success', 'message' => 'Vehicle updated successfully.'];
        } catch (\Throwable $e) {
            $result = ['status' => 'error', 'message' => $e->getMessage()];   
        }
        return $result;
    }

    public function deleteVehicle($id)
    {
        try {
            Vehicle::where('id', $id)->delete();
            $result = ['status' => 'success', 'message' => 'Vehicle deleted successfully.'];
        } catch (\Throwable $e) {
            $result = ['status' => 'error', 'message' => $e->getMessage()];
        }
        return $result;
    }

    public function updateAvailableStatus($inputs, $id)
    {
        $update = array();
        if (isset($inputs['available'])) {
            $update = [
                'availability' => $inputs['available']
            ];
        }
        try {
            Vehicle::where('id', $id)->update($update);
            $result = ['status' => 'success', 'message' => 'Vehicle status updated.'];
        } catch (\Throwable $e) {
            $result = ['status' => 'error', 'message' => $e->getMessage()];
        }
        return $result;
    }
}
