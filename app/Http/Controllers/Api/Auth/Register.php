<?php
namespace App\Http\Controllers\Api\Auth;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $this->validate($request, ['name' => 'required', 'email' => 'required|email|unique:users,email', 'password' => 'required|min:6|confirmed']);
        $user = User::create([
            'name' => request('name'),
            'email' => request('email'),
            'password' => Hash::make(request('password')),
        ]);
        return $user;
        // $params = [
        //     'grant_type' => 'passowrd',
        //     'client_id' => $this->client->id,
        //     'client_secret' => $this->client->secret,
        //     'user' => request('name'),
        //     'password' => request('password'),
        //     'scope' => '*'
        // ];
        // $request->request->add($params);
        // $proxy = Request::create('oath/token', 'POST');
        // return Route::dispatch($proxy);
        // dd($request);
    }
}