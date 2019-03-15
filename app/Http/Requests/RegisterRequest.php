<?php

namespace App\Http\Requests;

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
            'password' => 'required|min:6|confirmed'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name is required!',
            'body.required' => 'Email is required!',
            'password.required' => 'Password is required!',
            'password.min' => 'Password must be 6 characters long!'
        ];
    }
}
