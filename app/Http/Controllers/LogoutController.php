<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

// Request
use Illuminate\Http\Request;

// Contracts
use App\Contracts\LogoutContract;

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
