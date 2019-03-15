<?php
namespace App\Http\Controllers\Api\Auth\RegisterDomain;

use Illuminate\Http\Request;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\Auth\RegisterDomain\Contracts\RegisterContract;

class RegisterController extends Controller
{
    protected $registerRetriever;

    public function __construct(RegisterContract $registerContract)
    {
        $this->registerRetriever = $registerContract;
    }

    public function register(RegisterRequest $request)
    {
        return $this->registerRetriever->register($request);
    }
}
