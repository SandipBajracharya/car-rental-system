<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use RealRashid\SweetAlert\Facades\Alert;

class AdditionalUserInfoRequest extends FormRequest
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
            'document_image' => 'nullable|mimes:jpeg,png,jpg,gif,svg',
            'document_type' => 'required',
            'document_number' => 'required|string|regex:/^[A-Za-z0-9-]+$/' ,
            'dob' => 'nullable|date|date_format:Y-m-d',
            'name' => 'required',
            'gender' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Full name is required',
            'gender.required' => 'Gender is required',
            'document_type.required' => 'Document type is required.',
            'document_number.required' => 'Document number is required.',
            'document_image.required' => 'Document image is required.',
            'dob.date_format' => 'Date of birth format incorrect.'
        ];
    }

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
