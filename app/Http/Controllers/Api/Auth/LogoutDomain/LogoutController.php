<?php
namespace App\Http\Controllers\Api\Auth\LogoutDomain;

use Illuminate\Http\Request;
use App\Http\Requests\Auth\LoginLogoutRequest;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\Auth\LogoutDomain\Contracts\LogoutContract;

class LogoutController extends Controller
{
    protected $logoutRetriever;

    public function __construct(LogoutContract $logoutContract)
    {
        $this->logoutRetriever = $logoutContract;
    }

    public function logout(LoginLogoutRequest $request)
    {
        return $this->logoutRetriever->logout($request);
    }
}
