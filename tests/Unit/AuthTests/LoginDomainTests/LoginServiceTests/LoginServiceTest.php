<?php

namespace Tests\Feature;

use App\User;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;

use Mockery;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\Auth\LoginDomain\LoginController;
use App\Http\Controllers\Api\Auth\LoginDomain\Contracts\LoginContract;
use App\Http\Controllers\Api\Auth\LoginDomain\Services\LoginService;


class LoginServiceTest extends TestCase
{
    use DatabaseMigrations;
    private $service;

    public function setUp()
    {
        parent::setUp();
        $this->service = Mockery::mock(LoginService::class);
    }


    /**
     * A Mockery Test for Login Contoller
     *
     * @return json
     */
    public function test_login_service_with_mockery()
    {
        $username = "tes3t@email.com";
        $password = "tes3t@email.com";

        $expectedResponse = [
            "token_type" => "Bearer", "expires_in" => 31536000, "access_token" => "serializedToken", "refresh_token" => "serializedToken"
        ];

        $this->service
            ->shouldReceive('login')
            ->with($username, $password)
            ->once()->andReturn($expectedResponse);

        $response = $this->service->login($username, $password);

        $this->assertEquals($expectedResponse, $response);
    }
}
