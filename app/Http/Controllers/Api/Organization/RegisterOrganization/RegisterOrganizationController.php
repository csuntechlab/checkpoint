<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegisterOrganizationController extends Controller
{
    protected $registerRetriever;

    public function __construct(RegisterContract $registerContract)
    {
        $this->registerRetriever = $registerContract;
    }

    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed'
        ]);

        return $this->registerRetriever->register($request);
    }
}
