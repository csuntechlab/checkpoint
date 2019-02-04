<?php 
namespace App\Http\Controllers\Api\Auth\LoginDomain\Services;

use App\User;

use App\Http\Controllers\Api\Auth\LoginDomain\Services\GuzzleService;
use App\Http\Controllers\Api\Auth\LoginDomain\Contracts\LoginContract;



class LoginService implements LoginContract
{

	public function login($request)
	{

		$username = $request->username;
		$password = $request->password;


		$guzzle = new GuzzleService(new \GuzzleHttp\Client, new LoginGuzzleParam($username, $password));

		return $guzzle->login();
	}

}
