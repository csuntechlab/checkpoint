<?php
namespace App\Http\Controllers\Api\Auth\RegisterDomain;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Controllers\Api\Auth\RegisterDomain\Contracts\RegisterContract;

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
