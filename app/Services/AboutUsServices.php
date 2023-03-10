<?php

namespace App\Services;

use App\Models\About;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use DataTables;

class AboutUsServices
{
    public function findById($id)
    {
        return About::find($id);
    }

    public function findLatestContent()
    {
        return About::orderBy('updated_at', 'DESC')->first();
    }

    public function countContent()
    {
        return About::count();
    }

    public function getIndexDataTable()
    {
        $data = About::orderBy('created_at', 'ASC')->get();
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row) {
                $btn = '<div class="flex-end gap-8">
                        <button class="btn btn-ghost-gray btn-sm edit_btn" data-bs-toggle="offcanvas"
                            data-bs-target="#offcanvasAboutEdit"
                            aria-controls="offcanvasAboutEdit" data-about_id="'.$row->id.'">
                            <i class="ic-edit"></i>
                        </button>
                    </div>';
                return $btn;
            })
            ->addColumn('description1', function($row) {
                return excerpt($row->description1, 35);
            })
            ->addColumn('description2', function($row) {
                return excerpt($row->description2, 35);
            })
            ->addColumn('image', function($row) {
                $img = '<img src="/images/aboutUs/'.$row->image.'" alt="" />';
                return $img;
            })
            ->rawColumns(['action', 'description1', 'description2', 'image'])
            ->make(true);
    }
        
    public function addAbout($inputs)
    {
        if ($inputs->hasFile('image')) {
            $file = $inputs['image'];
            $ext = $file->getClientOriginalExtension();
            $name = time().'.'.$ext;
            $file->move(public_path().'/images/aboutUs/', $name);  
            $filenamesToStore = $name;
        } else {
            $filenamesToStore = '';
        }

        $content = [
            'heading1' => $inputs['heading1'],
            'description1' => $inputs['description1'],
            'heading2' => $inputs['heading2'],
            'description2' => $inputs['description2'],
            'image' => $filenamesToStore
        ];

        try {
            About::create($content);
            $result = ['status' => 'success', 'message' => 'About us content added successfully.'];
        } catch (\Throwable $e) {
            $result = ['status' => 'error', 'message' => $e->getMessage()];
        }
        return $result;
    }

    public function updateAbout($inputs, $id)
    {
        $about = $this->findById($id);
        $content = array();
        $image = array();
        if ($inputs->hasFile('image')) {
            $file = $inputs['image'];
            $ext = $file->getClientOriginalExtension();
            $name = time().'.'.$ext;
            $file->move(public_path().'/images/aboutUs/', $name);  
            $filenamesToStore = $name;
            $image = ['image' => $filenamesToStore];

            if (Storage::disk('public_disk')->exists('/images/aboutUs/'.$about->image)) {
                Storage::disk('public_disk')->delete('/images/aboutUs/'.$about->image);
            }
        }

        $content = [
            'heading1' => $inputs['heading1'],
            'description1' => $inputs['description1'],
            'heading2' => $inputs['heading2'],
            'description2' => $inputs['description2']
        ];
        $content = array_merge($content, $image);

        try {
            About::where('id', $id)->update($content);
            $result = ['status' => 'success', 'message' => 'About us content updated successfully.'];
        } catch (\Throwable $e) {
            $result = ['status' => 'error', 'message' => $e->getMessage()];   
        }
        return $result;
    }
}
