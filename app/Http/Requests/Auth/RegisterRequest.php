<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'invitation_code' => 'required|digits:6'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name is required!',
            'email.required' => 'Email is required!',
            'email.email' => 'Email is invalid.',
            'email' => [
                'unique' => 'email is not unique'
            ],
            'password.required' => 'Password is required!',
            'password.min' => 'Password must be 6 characters long!',
            'invitation_code.digits' => 'Incorrect code!',
        ];
    }
}
