<?php

namespace App\Http\Controllers\Api\Auth\LoginDomain;

use Illuminate\Http\Request;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\Auth\LoginDomain\Contracts\LoginContract;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    protected $loginUtility;

    public function __construct(LoginContract $loginContract)
    {
        $this->loginUtility = $loginContract;
    }

    public function login(LoginRequest $request)
    {
        return $this->loginUtility->login($request);
    }
}
