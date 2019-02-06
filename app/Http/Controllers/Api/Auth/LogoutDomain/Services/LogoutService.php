<?php 
namespace App\Http\Controllers\Api\Auth\LogoutDomain\Services;

use App\User;
use App\Http\Controllers\Api\Auth\LogoutDomain\Contracts\LogoutContract;


class LogoutService implements LogoutContract
{

    public function logout($request)
    {
        auth()->user()->tokens->each(function ($token, $key) {
            $token->delete();
        });

        return response()->json("Logout was succesful!");
    }

}
