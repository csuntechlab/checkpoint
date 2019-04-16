<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClockOutRequest extends FormRequest
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
            'longitude' => 'required',
            'latitude' => 'required',
            'radius' => 'required',
            'address_number' => 'required',
            'street' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zip' => 'required'
        ];
    }
}
