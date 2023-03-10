<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
            'address' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|email',
            'facebook_link' => 'nullable|string',
            'twitter_link' => 'nullable|string',
            'insta_link' => 'nullable|string',
            'map' => 'nullable|string'
        ];
    }
}
