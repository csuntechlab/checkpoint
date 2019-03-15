<?php 
namespace App\Http\Controllers\Api\Auth\LoginDomain\Services;

use App\Http\Controllers\Api\Auth\LoginDomain\Contracts\LoginContract;
use App\Http\Controllers\Api\Auth\LoginDomain\Services\GuzzleLogin\GuzzleService;
use App\Http\Controllers\Api\Auth\LoginDomain\Services\GuzzleLogin\LoginGuzzleParam;


use \GuzzleHttp\Client as HttpClient;


class LoginService implements LoginContract
{

    public function login($username, $password)
    {

        $guzzle = new GuzzleService(new HttpClient, new LoginGuzzleParam($username, $password));

        return $guzzle->login();
    }
}
