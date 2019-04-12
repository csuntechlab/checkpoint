<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

// Request
use App\Http\Requests\Auth\LoginRequest;

// Contract
use App\Contracts\LoginContract;

class LoginController extends Controller
{
    protected $loginUtility;

    public function __construct(LoginContract $loginContract)
    {
        $this->loginUtility = $loginContract;
    }

    public function login(LoginRequest $request)
    {
        return $this->loginUtility->login($request['email'], $request['password']);
    }
}
