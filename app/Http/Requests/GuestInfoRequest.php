<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GuestInfoRequest extends FormRequest
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
            'full_name' => 'required',
            'email' => 'required',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'street' => 'required',
            'postal_code' => 'required',
            'dob' => 'required|date|date_format:Y-m-d',
            'document_image' => 'nullable|mimes:jpeg,png,jpg,gif,svg',
            'document_type' => 'required',
            'document_number' => 'required|string',
            'document_country' => 'required|string',
            'document_expire' => 'required|date',
            'notes' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'full_name.required' => 'Full name is required',
            'document_type.required' => 'Document type is required.',
            'document_number.required' => 'Document number is required.',
            'document_image.required' => 'Document image is required.',
            'document_expire.required' => 'Document number is required.',
            'dob.date_format' => 'Date of birth format incorrect.',
            'postal_code.required' => 'Postal code is required',
            'dob.required' => 'Date of birth is required'
        ];
    }
}
