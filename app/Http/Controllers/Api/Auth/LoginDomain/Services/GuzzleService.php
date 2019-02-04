<?php 
namespace App\Http\Controllers\Api\Auth\LoginDomain\Services;

use \GuzzleHttp\Client as Guzzle;

class GuzzleService
{

    protected $http;
    protected $loginParam;

    public function __construct(Guzzle $http, LoginGuzzleParam $loginParam)
    {
        $this->http = $http;
        $this->loginParam = $loginParam;
    }

    public function login()
    {
        try {
            $response = $this->http->post($this->loginParam->endPoint(), $this->loginParam->formParams());
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
