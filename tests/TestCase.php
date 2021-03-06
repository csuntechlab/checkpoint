<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Services\LoginService;
use App\ModelRepositories\UserModelRepository;
use App\Models\Organization;

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
        $classPath = "App\Services\LoginService";
        $service = new LoginService();
        $function = 'createToken';

        $method = $this->get_private_method($classPath, $function);
        $response = $method->invoke($service, $user);
        return $response['token_type'] . " " . $response['access_token'];
    }

    public function createAdminUser()
    {
        $userModelRepository = new UserModelRepository();

        $name = "name";
        $email = "name";
        $password = "name";
        $organizationId = Organization::all()->random()->id;
        $adminRoleId = 1;

        return $userModelRepository->create($name, $email, $password, $organizationId, $adminRoleId)["user"];
    }
}
