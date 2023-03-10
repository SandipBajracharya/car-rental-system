<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AboutRequest extends FormRequest
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
            'heading1' => 'required|string',
            'description1' => 'required|string',
            'heading2' => 'nullable|string',
            'description2' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg'
        ];
    }
}
