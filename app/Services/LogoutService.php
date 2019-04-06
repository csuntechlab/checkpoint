<?php
namespace App\Services;

use App\User;
use App\Contracts\LogoutContract;


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


    return response()->json("Logout was successful!");
  }
}
