<?php

namespace App\Http\Controllers\Api\Auth\LoginDomain;

use Illuminate\Http\Request;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\Auth\LoginDomain\Contracts\LoginContract;

class LoginController extends Controller
{
    protected $loginUtility;

    public function __construct(LoginContract $loginContract)
    {
        $this->loginUtility = $loginContract;
    }

    private function getParam($request): array
    {
        $data = array();
        $data['username'] =  $request->username;
        $data['password'] = $request->password;
        return $data;
    }


    public function login(LoginRequest $request)
    {
        $data = $this->getParam($request);

        return $this->loginUtility->login($data['username'], $data['password']);
    }
}
