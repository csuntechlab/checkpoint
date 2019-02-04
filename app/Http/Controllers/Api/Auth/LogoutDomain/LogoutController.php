<?php
namespace App\Http\Controllers\Api\Auth\LogoutDomain;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\Auth\LogoutDomain\Contracts\LogoutContract;

class LogoutController extends Controller
{
    protected $logoutRetriever;

    public function __construct(LogoutContract $logoutContract)
    {
        $this->logoutRetriever = $logoutContract;
    }

    public function logout(Request $request)
    {
        dd('check');
        dd($request);
        return $this->logoutRetriever->logout($request);
    }
}