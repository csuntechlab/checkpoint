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

    private function getParam($request): array
    {
        $data = array();
        $data['username'] =  $request->username;
        $data['password'] = $request->password;
        return $data;
    }


    public function login(Request $request)
    {
        $data = $this->getParam($request);

        return $this->loginRetriever->login($data['username'], $data['password']);
    }
}
