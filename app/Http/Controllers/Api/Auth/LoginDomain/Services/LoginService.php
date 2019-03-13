<?php 
namespace App\Http\Controllers\Api\Auth\LoginDomain\Services;

use App\Http\Controllers\Api\Auth\LoginDomain\Contracts\LoginContract;
use App\Http\Controllers\Api\Auth\LoginDomain\Services\GuzzleLogin\GuzzleService;
use App\Http\Controllers\Api\Auth\LoginDomain\Services\GuzzleLogin\LoginGuzzleParam;


use \GuzzleHttp\Client as GuzzleHttpClient;


class LoginService implements LoginContract
{

    public function login($username, $password)
    {

        $guzzle = new GuzzleService(new GuzzleHttpClient, new LoginGuzzleParam($username, $password));

        return $guzzle->login();
    }
}
