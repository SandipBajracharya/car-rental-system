<?php

namespace App\Services;

use App\Models\Contact;
use App\Models\Feedback;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use DataTables;

class ContactServices
{
    public function findContactById($id)
    {
        return Contact::find($id);
    }

    public function findLatestContact()
    {
        return Contact::orderBy('updated_at', 'DESC')->first();
    }

    public function countContact()
    {
        return Contact::count();
    }

    public function getIndexDataTable()
    {
        $data = Contact::orderBy('created_at', 'ASC')->get();
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row) {
                $btn = '<div class="flex-end gap-8">
                        <button class="btn btn-ghost-gray btn-sm edit_btn" data-bs-toggle="offcanvas"
                            data-bs-target="#offcanvasContactEdit"
                            aria-controls="offcanvasContactEdit" data-contact_id="'.$row->id.'">
                            <i class="ic-edit"></i>
                        </button>
                    </div>';
                return $btn;
            })
            ->addColumn('map', function($row) {
                return excerpt($row->map, 35);
            })
            ->rawColumns(['action', 'map'])
            ->make(true);
    }
        
    public function addContact($inputs)
    {
        $content = [
            'address' => $inputs['address'],
            'phone' => $inputs['phone'],
            'email' => $inputs['email'],
            'facebook_link' => $inputs['facebook_link'],
            'twitter_link' => $inputs['twitter_link'],
            'insta_link' => $inputs['insta_link'],
            'map' => $inputs['map']
        ];

        try {
            Contact::create($content);
            $result = ['status' => 'success', 'message' => 'Contact added successfully.'];
        } catch (\Throwable $e) {
            $result = ['status' => 'error', 'message' => $e->getMessage()];
        }
        return $result;
    }

    public function updateContact($inputs, $id)
    {
        $content = [
            'address' => $inputs['address'],
            'phone' => $inputs['phone'],
            'email' => $inputs['email'],
            'facebook_link' => $inputs['facebook_link'],
            'twitter_link' => $inputs['twitter_link'],
            'insta_link' => $inputs['insta_link'],
            'map' => $inputs['map']
        ];

        try {
            Contact::where('id', $id)->update($content);
            $result = ['status' => 'success', 'message' => 'Contact updated successfully.'];
        } catch (\Throwable $e) {
            $result = ['status' => 'error', 'message' => $e->getMessage()];   
        }
        return $result;
    }

    public function getFeedbackIndexDataTable()
    {
        $data = Feedback::orderBy('created_at', 'DESC')->get();
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row) {
                $btn = '<div class="flex-end gap-8">
                            <button
                                class="btn btn-ghost-gray btn-sm delete-btn" data-bs-toggle="modal"
                                data-bs-target="#confirmationModal" data-feedback_id="'.$row->id.'">
                                <i class="ic-delete"></i>
                            </button>
                    </div>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
        
    public function addFeedback($inputs)
    {
        $feedback = [
            'fullname' => $inputs['fullname'],
            'email' => $inputs['email'],
            'subject' => $inputs['subject'],
            'message' => $inputs['message']
        ];

        try {
            Feedback::create($feedback);
            $result = ['status' => 'success', 'message' => 'Your feedback has been submitted successfully. Thank you!'];
        } catch (\Throwable $e) {
            $result = ['status' => 'error', 'message' => $e->getMessage()];
        }
        return $result;
    }

    public function deleteFeedback($id)
    {
        try {
            Feedback::where('id', $id)->delete();
            $result = ['status' => 'success', 'message' => 'Feedback deleted successfully.'];
        } catch (\Throwable $e) {
            $result = ['status' => 'error', 'message' => $e->getMessage()];
        }
        return $result;
    }
}
