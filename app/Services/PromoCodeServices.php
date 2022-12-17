<?php

namespace App\Services;

use App\Models\PromoCode;
use Auth;
use DataTables;

class PromoCodeServices
{
    public function findPromoCodeById($id)
    {
        return PromoCode::find($id);
    }

    public function getIndexDataTable()
    {
        $data = PromoCode::orderBy('created_at', 'DESC')->get();
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('status', function($row) {
                $btn = '<div class="form-check form-switch promo-status-switch" data-promo_id="'.$row->id.'">
                    <input class="form-check-input" type="checkbox" id="switch01"';
                $row->status === 1? $btn .= 'checked' : false;
                $btn .= '/></div>';
                return $btn;
            })
            ->addColumn('action', function($row) {
                $btn = '<div class="gap-8">
                        <button class="btn btn-ghost-gray btn-sm edit_btn" data-bs-toggle="offcanvas"
                            data-bs-target="#offcanvasPromoEdit"
                            aria-controls="offcanvasPromoEdit" data-promo_id="'.$row->id.'">
                            <i class="ic-edit"></i>
                        </button>
                        <button
                            class="btn btn-ghost-gray btn-sm delete-btn" data-bs-toggle="modal"
                            data-bs-target="#confirmationModal" data-promo_id="'.$row->id.'">
                            <i class="ic-delete"></i>
                        </button>
                    </div>';
                return $btn;
            })
            ->rawColumns(['status','action'])
            ->make(true);
    }
        
    public function addPromoCode($inputs)
    {
        $promo_code = [
            'promo_name' => $inputs['promo_name'],
            'promo_code' => $inputs['promo_code'],
            'discount_percentage' => $inputs['discount_percentage'],
            'max_discount' => $inputs['max_discount'] ?? 0,
            'created_by' => Auth::user()->id
        ];

        try {
            PromoCode::create($promo_code);
            $result = ['status' => 'success', 'message' => 'Promo code added successfully.'];
        } catch (\Throwable $e) {
            $result = ['status' => 'error', 'message' => $e->getMessage()];
        }
        return $result;
    }

    public function updatePromoCode($inputs, $id)
    {
        $promo_code = [
            'promo_name' => $inputs['promo_name'],
            'promo_code' => $inputs['promo_code'],
            'discount_percentage' => $inputs['discount_percentage'],
            'max_discount' => $inputs['max_discount'] ?? 0,
            'updated_by' => Auth::user()->id
        ];

        try {
            PromoCode::where('id', $id)->update($promo_code);
            $result = ['status' => 'success', 'message' => 'Promo code updated successfully.'];
        } catch (\Throwable $e) {
            $result = ['status' => 'error', 'message' => $e->getMessage()];   
        }
        return $result;
    }

    public function deletePromoCode($id)
    {
        try {
            PromoCode::where('id', $id)->delete();
            $result = ['status' => 'success', 'message' => 'Promo code deleted successfully.'];
        } catch (\Throwable $e) {
            $result = ['status' => 'error', 'message' => $e->getMessage()];
        }
        return $result;
    }

    public function updatePromoCodeStatus($inputs, $id)
    {
        $update = array();
        if (isset($inputs['status'])) {
            $update = [
                'status' => $inputs['status']
            ];
        }
        try {
            PromoCode::where('id', $id)->update($update);
            $result = ['status' => 'success', 'message' => 'Promo code status updated.'];
        } catch (\Throwable $e) {
            $result = ['status' => 'error', 'message' => $e->getMessage()];
        }
        return $result;
    }
}
