<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginLogoutRequest extends FormRequest
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
            'username' => 'required|email|unique:users,email|exists:user,email',
            'password' => 'required|confirmed'
        ];
    }

    public function messages()
    {
        return [
            'username.required' => 'Username is required!',
            'username.email' => 'Username must be an email!',
            'password.required' => 'Password is required!'
        ];
    }
}
