<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VehicleRequest extends FormRequest
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
            'model' => 'required',
            'plate_number' => 'required',
            'mileage' => 'required',
            'fuel_volume' => 'required',
            'occupancy' => 'required',
            'pricing' => 'required',
            'is_reserved_now' => 'required',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg',
        ];
    }

    public function messages()
    {
        return [
            'images.*' => 'Images must be an image.',
            'is_reserved_now.required' => 'The status field is required',
        ];
    }
}
