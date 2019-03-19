<?php
namespace App\Http\Controllers\Api\Auth\LogoutDomain\Services;

use App\User;
use App\Http\Controllers\Api\Auth\LogoutDomain\Contracts\LogoutContract;


class LogoutService implements LogoutContract
{

  public function logout($request)
  {
    try {
      auth()->user()->tokens->each(function ($token, $key) {
        $token->delete();
      });
    } catch (\Exception $e) {
      return [
        'status_code' => 403,
        'message_error' => 'Logout failed'
      ];
    }


    return response()->json("Logout was succesful!");
  }
}
