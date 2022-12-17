<?php

namespace App\Services;

use App\Models\HomeSlider;
use App\Models\HomeTopVehicle;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use DataTables;

class HomePageServices
{
    public function findSliderContentById($id)
    {
        return HomeSlider::find($id);
    }

    public function findAllHomeSliders()
    {
        return HomeSlider::orderBy('created_at', 'DESC')->get();
    }

    public function getIndexDataTable()
    {
        $data = HomeSlider::orderBy('created_at', 'DESC')->get();
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('images', function($row) {
                $img = '<img src="/images/homeSliders/'.$row->images.'" alt="" />';
                return $img;
            })
            ->addColumn('action', function($row) {
                $btn = '<div class="flex-end gap-8">
                        <button class="btn btn-ghost-gray btn-sm edit_btn" data-bs-toggle="offcanvas"
                            data-bs-target="#offcanvasHomeSliderEdit"
                            aria-controls="offcanvasHomeSliderEdit" data-home_slider_id="'.$row->id.'">
                            <i class="ic-edit"></i>
                        </button>
                        <button
                            class="btn btn-ghost-gray btn-sm delete-btn" data-bs-toggle="modal"
                            data-bs-target="#confirmationModal" data-home_slider_id="'.$row->id.'">
                            <i class="ic-delete"></i>
                        </button>
                    </div>';
                return $btn;
            })
            ->rawColumns(['images', 'action'])
            ->make(true);
    }
        
    public function addHomeSlider($inputs)
    {
        if ($inputs->hasFile('image')) {
            $file = $inputs['image'];
            $ext = $file->getClientOriginalExtension();
            $name = time().'.'.$ext;
            $file->move(public_path().'/images/homeSliders/', $name);  
            $filenamesToStore = $name;
        } else {
            $filenamesToStore = '';
        }

        $homeSlider = [
            'heading' => $inputs['heading'],
            'images' => $filenamesToStore,
            'created_by' => Auth::user()->id
        ];

        try {
            HomeSlider::create($homeSlider);
            $result = ['status' => 'success', 'message' => 'Home slider added successfully.'];
        } catch (\Throwable $e) {
            $result = ['status' => 'error', 'message' => $e->getMessage()];
        }
        return $result;
    }

    public function updateHomeSlider($inputs, $id)
    {
        $homeSlider = array();
        $image = array();
        if ($inputs->hasFile('image')) {
            $file = $inputs['image'];
            $ext = $file->getClientOriginalExtension();
            $name = time().'.'.$ext;
            $file->move(public_path().'/images/homeSliders/', $name);  
            $filenamesToStore = $name;
            $image = ['images' => $filenamesToStore];
        }

        $homeSlider = [
            'heading' => $inputs['heading'],
            'updated_by' => Auth::user()->id
        ];
        $homeSlider = array_merge($homeSlider, $image);

        try {
            HomeSlider::where('id', $id)->update($homeSlider);
            $result = ['status' => 'success', 'message' => 'Home slider updated successfully.'];
        } catch (\Throwable $e) {
            $result = ['status' => 'error', 'message' => $e->getMessage()];   
        }
        return $result;
    }

    public function deleteHomeSlider($id)
    {
        try {
            $slider = $this->findSliderContentById($id);
            if (Storage::disk('public_disk')->exists('/images/homeSliders/'.$slider->images)) {
                Storage::disk('public_disk')->delete('/images/homeSliders/'.$slider->images);
            }
            HomeSlider::where('id', $id)->delete();
            $result = ['status' => 'success', 'message' => 'Home slider deleted successfully.'];
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
            HomeSlider::where('id', $id)->update($update);
            $result = ['status' => 'success', 'message' => 'Home slider status updated.'];
        } catch (\Throwable $e) {
            $result = ['status' => 'error', 'message' => $e->getMessage()];
        }
        return $result;
    }

    public function findTopVehicle()
    {
        return HomeTopVehicle::orderBy('updated_at', 'DESC')->first();
    }

    public function updateHomeTopVehicles($inputs)
    {
        $id = $inputs['id'];
        $payload = [
            'vehicle1' => $inputs['vehicle1'],
            'vehicle2' => $inputs['vehicle2']
        ];

        try {
            HomeTopVehicle::updateOrCreate(
                [
                    'id' => $id
                ],
                $payload
            );
            $result = ['status' => 'success', 'message' => 'Home slider status updated.'];
        } catch (\Throwable $e) {
            $result = ['status' => 'error', 'message' => $e->getMessage()];
        }
        return $result;
    }
}
