<?php 
namespace App\Http\Controllers\Api\Auth\LoginDomain\Services;

use App\User;
use App\Http\Controllers\Api\Auth\LoginDomain\Contracts\LoginContract;
use App\Http\Controllers\Api\Auth\LoginDomain\Services\GuzzleLogin\GuzzleService;
use App\Http\Controllers\Api\Auth\LoginDomain\Services\GuzzleLogin\LoginGuzzleParam;


use \GuzzleHttp\Client as Guzzle;


class LoginService implements LoginContract
{

	public function login($request)
	{
		$username = $request->username;
		$password = $request->password;

		$guzzle = new GuzzleService(new Guzzle, new LoginGuzzleParam($username, $password));

		return $guzzle->login();
	}

}
