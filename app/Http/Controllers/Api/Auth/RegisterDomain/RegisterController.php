<?php
namespace App\Http\Controllers\Api\Auth\RegisterDomain;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\Auth\RegisterDomain\Contracts\RegisterContract;
use App\User;

class RegisterController extends Controller
{
    protected $registerRetriever;

    public function __construct(RegisterContract $registerContract)
    {
        $this->registerRetriever = $registerContract;
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

    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            // 'invite_code' => 'required'
        ]);

        $data = $this->getParam($request);

        return $this->registerRetriever->register($data['name'], $data['email'], $data['password'], $data['invite_code']);
    }
}
