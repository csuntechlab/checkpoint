<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

// Request
use App\Http\Requests\Auth\RegisterRequest;

// Contracts
use App\Contracts\RegisterContract;

class RegisterController extends Controller
{
    protected $registerUtility;

    public function __construct(RegisterContract $registerContract)
    {
        $this->registerUtility = $registerContract;
    }

    public function register(RegisterRequest $request)
    {
        $request['invite_code'] = "000-000";

        return $this->registerUtility->register($request['name'], $request['email'], $request['password'], $request['invite_code']);
    }
}
