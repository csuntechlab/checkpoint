<?php
namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LogoutController extends Controller
{
    public function logout(Request $request)
    {

        auth()->user()->tokens->each(function ($token, $key) {
            $token->delete();
        });

        return response()->json("Logout was succesful!");
    }
}