<?php
namespace App\Http\Controllers\Api\Auth\RegisterDomain;

use Illuminate\Http\Request;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\Auth\RegisterDomain\Contracts\RegisterContract;
use App\User;

class RegisterController extends Controller
{
    protected $registerUtility;

    public function __construct(RegisterContract $registerContract)
    {
        $this->registerUtility = $registerContract;
    }

    private function getParam($request): array
    {
        $data = array();
        $data['name'] = (string)$request['name'];
        $data['email'] = (string)$request['email'];
        $data['password'] = (string)$request['password'];
        $data['invite_code'] = "000-000";
        return $data;
    }

    public function register(RegisterRequest $request)
    {
        $data = $this->getParam($request);

        return $this->registerUtility->register($data['name'], $data['email'], $data['password'], $data['invite_code']);
    }
}
