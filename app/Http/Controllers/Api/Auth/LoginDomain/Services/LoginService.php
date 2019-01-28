<?php 
namespace App\Http\Controllers\Api\Auth\LoginDomain\Services;

use App\User;
use App\Http\Controllers\Api\Auth\LoginDomain\Contracts\LoginContract;


class LoginService implements LoginContract
{

	public function login($request)
	{
		$http = new \GuzzleHttp\Client;
		try {
			$response = $http->post(config('services.passport.login_endpoint'), [
				'form_params' => [
					'grant_type' => 'password',
					'client_id' => config('services.passport.client_id'),
					'client_secret' => config('services.passport.client_secret'),
					'username' => $request->username,
					'password' => $request->password,
				]
			]);
			return $response->getBody();
		} catch (\GuzzleHttp\Exception\BadResponseException $e) {
			if ($e->getCode() == 400) {
				return response()->json('Invalid Request. Please enter a username or a password', $e->getCode());
			} else if ($e->getCode() == 401) {
				return response()->json('Your Credentials are incorrect. Please try again', $e->getCode());
			}
			return response()->json('Something went wrong with the server', $e->getCode());
		}
	}

}