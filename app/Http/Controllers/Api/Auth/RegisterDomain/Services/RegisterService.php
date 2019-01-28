<?php 
namespace App\Http\Controllers\Api\Auth\RegisterDomain\Services;

use App\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Api\Auth\RegisterDomain\Contracts\RegisterContract;


class RegisterService implements RegisterContract
{

    public function register($request)
    {
        $user = User::create([
            'name' => request('name'),
            'email' => request('email'),
            'password' => Hash::make(request('password')),
        ]);

        return $user;
    }

}
