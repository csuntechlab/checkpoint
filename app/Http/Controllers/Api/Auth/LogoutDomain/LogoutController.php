<?php
namespace App\Http\Controllers\Api\Auth\LogoutDomain;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\Auth\LogoutDomain\Contracts\LogoutContract;

class LogoutController extends Controller
{
    protected $logoutUtility;

    public function __construct(LogoutContract $logoutContract)
    {
        $this->logoutUtility = $logoutContract;
    }

    public function logout(Request $request)
    {
        return $this->logoutUtility->logout($request);
    }
}
