<?php

namespace App\Services;

use App\Models\Faq;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use DataTables;

class FaqServices
{
    public function findFaqById($id)
    {
        return Faq::find($id);
    }

    public function findAllFaqs($limit = null, $offset = null)
    {
        $faq = Faq::query();

        if (!empty($offset)) {
            $faq->skip($offset);
        }
        
        if (!empty($limit)) {
            $faq->limit($limit);
        }
        return $faq->orderBy('created_at', 'ASC')->get();
    }

    public function getIndexDataTable()
    {
        $data = Faq::orderBy('created_at', 'ASC')->get();
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row) {
                $btn = '<div class="flex-end gap-8">
                        <button class="btn btn-ghost-gray btn-sm edit_btn" data-bs-toggle="offcanvas"
                            data-bs-target="#offcanvasFaqEdit"
                            aria-controls="offcanvasFaqEdit" data-faq_id="'.$row->id.'">
                            <i class="ic-edit"></i>
                        </button>
                        <button
                            class="btn btn-ghost-gray btn-sm delete-btn" data-bs-toggle="modal"
                            data-bs-target="#confirmationModal" data-faq_id="'.$row->id.'">
                            <i class="ic-delete"></i>
                        </button>
                    </div>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
        
    public function addFaq($inputs)
    {
        $content = [
            'question' => $inputs['question'],
            'answer' => $inputs['answer']
        ];

        try {
            Faq::create($content);
            $result = ['status' => 'success', 'message' => 'FAQ added successfully.'];
        } catch (\Throwable $e) {
            $result = ['status' => 'error', 'message' => $e->getMessage()];
        }
        return $result;
    }

    public function updateFaq($inputs, $id)
    {
        $content = [
            'question' => $inputs['question'],
            'answer' => $inputs['answer']
        ];

        try {
            Faq::where('id', $id)->update($content);
            $result = ['status' => 'success', 'message' => 'FAQ updated successfully.'];
        } catch (\Throwable $e) {
            $result = ['status' => 'error', 'message' => $e->getMessage()];   
        }
        return $result;
    }

    public function deleteFaq($id)
    {
        try {
            Faq::where('id', $id)->delete();
            $result = ['status' => 'success', 'message' => 'FAQ deleted successfully.'];
        } catch (\Throwable $e) {
            $result = ['status' => 'error', 'message' => $e->getMessage()];
        }
        return $result;
    }
}
