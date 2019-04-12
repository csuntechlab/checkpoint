<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterAdminRequest extends FormRequest
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
          'organization_name' => 'required',
          'first_name' => 'required',
          'last_name' => 'required',
          'email' => 'required|email|unique:users,email',
          'password' => 'required|min:6|confirmed',
          'address_number' => 'required',
          'street' => 'required',
          'city' => 'required',
          'country' => 'required',
          'zip_code' => 'required'
        ];
    }

    public function messages()
    {
        return[
          'organization_name.required' => 'Organization is required!',
          'first_name.required' => 'First name is required!',
          'last_name.required' => 'Last name is required!',
          'email.required' => 'Email is required!',
          'email.email' => 'Email is invalid.',
          'email' => [
            'unique' => 'Email is not unique'
          ],
          'password.required' => 'Password is required!',
          'password.min' => 'Password must be 6 characters long!',
          'address_number.required' => 'One address is required!',
          'city.required' => 'City is required!',
          'country.required' => 'Country is required!',
          'zip_code.required' => 'Zip code is required!'
        ];
    }
}
