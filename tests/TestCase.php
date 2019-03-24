<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\Auth\LoginDomain\Services\LoginService;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function get_private_method($classPath, $function)
    {
        $method = new \ReflectionMethod($classPath, $function);
        $method->setAccessible(true);
        return $method;
    }

    public function get_auth_token($user)
    {
        $classPath = "App\Http\Controllers\Api\Auth\LoginDomain\Services\LoginService";
        $service = new LoginService();
        $function = 'createToken';

        $method = $this->get_private_method($classPath, $function);
        $response = $method->invoke($service, $user);
        return $response['token_type'] . " " . $response['access_token'];
    }
}
