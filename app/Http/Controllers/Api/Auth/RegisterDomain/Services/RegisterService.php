<?php 
namespace App\Http\Controllers\Api\Auth\RegisterDomain\Services;

use App\User;
use Illuminate\Support\Facades\Hash;

use lluminate\Foundation\Exceptions;
use \Exception as Exception;

use App\Http\Controllers\Api\Auth\RegisterDomain\Contracts\RegisterContract;


class RegisterService implements RegisterContract
{

    public function register($request)
    {
        try {
            $name = $request['name'];
            $email = $request['email'];
            $password = $request['password'];
        } catch (Exception $e) {
            return ['message_error' => 'User was not successfully created.'];
        }

        try {
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
            ]);
            return $user;
        } catch (QueryException $e) {
            return ['message_error' => 'User was not successfully created.'];
        }
    }

}
