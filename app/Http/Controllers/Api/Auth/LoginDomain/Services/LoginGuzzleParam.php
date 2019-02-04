<?php 
namespace App\Http\Controllers\Api\Auth\LoginDomain\Services;

class LoginGuzzleParam
{
    protected $loginEndPoint;
    protected $formParams;

    public function __construct($username, $password)
    {
        $this->loginEndPoint = config('services.passport.login_endpoint');

        $clientId = config('services.passport.client_id');
        $clientSecret = config('services.passport.client_secret');

        $this->formParams = [
            'form_params' => [
                'grant_type' => 'password',
                'client_id' => $clientId,
                'client_secret' => $clientSecret,
                'username' => $username,
                'password' => $password,
            ]
        ];
    }

    public function endPoint()
    {
        return $this->loginEndPoint;
    }

    public function formParams()
    {
        return $this->formParams;
    }


}
