<?php
namespace App\Http\Controllers\Api\Auth\RegisterDomain;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\Auth\RegisterDomain\Contracts\RegisterContract;

class RegisterController extends Controller
{
    protected $registerRetriever;

    public function __construct(RegisterContract $registerContract)
    {
        $this->registerRetriever = $registerContract;
    }

    public function register(Request $request)
    {
        // $this->validate($request, ['name' => 'required', 'email' => 'required|email|unique:users,email', 'password' => 'required|min:6|confirmed']);

        return $this->registerRetriever->register($request);
    }
}
