<?php

namespace App\Http\Controllers\Api\Auth\LoginDomain;

use Illuminate\Http\Request;
use App\Http\Requests\Auth\LoginLogoutRequest;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\Auth\LoginDomain\Contracts\LoginContract;

class LoginController extends Controller
{
    protected $loginRetriever;

    public function __construct(LoginContract $loginContract)
    {
        $this->loginRetriever = $loginContract;
    }

    public function login(LoginLogoutRequest $request)
    {
        return $this->loginRetriever->login($request);
    }
}
