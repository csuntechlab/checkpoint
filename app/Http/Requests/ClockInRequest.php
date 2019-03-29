<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClockInRequest extends FormRequest
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
            'date' => array('required', 'Date'),
            'time' => array('required', 'regex:/^([01]?[0-9]|2[0-3]):([0-5][0-9]):([0-5][0-9]|60)$/'),
        ];
    }
}
