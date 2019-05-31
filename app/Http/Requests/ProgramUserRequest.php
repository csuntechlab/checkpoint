<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProgramUserRequest extends FormRequest
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
            'user_id' => 'required',
            'program_id' => 'required',
            'program_name' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'user.required' => 'user is required!',
            'program.required' => 'program is required!',
            'program_name.required' => "program is required!"
        ];
    }
}
