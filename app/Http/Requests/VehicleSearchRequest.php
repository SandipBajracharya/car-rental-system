<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use RealRashid\SweetAlert\Facades\Alert;

class VehicleSearchRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'pickup_location' => 'required',
            'start_dt' => 'required|date|after:yesterday',
            'end_dt' => 'required|date|after_or_equal:start_dt',
        ];
    }

    public function messages()
    {
        return [
            'pickup_location.required' => 'A pickup location is required',
            'start_dt.required' => 'A pickup datetime is required',
            'start_dt.after' => 'Pickup date must be greater or same as today',
            'end_dt.required' => 'A drop-off datetime is required',
            'end_dt.after_or_equal' => 'End date must be greater than pickup date',
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $message = '';
        $validator->after(function ($validator) use ($message) {
            if (count($validator->errors()->messages()) > 0) {
                foreach ($validator->errors()->messages() as $error) {
                    $message .= $error[0].'. ';
                }
            }
            if ($message != '') {
                Alert::toast($message, 'info');
            }
        });
    }
}
