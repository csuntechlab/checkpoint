<?php

namespace Tests\Feature;

use App\User;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;

use Mockery;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\LoginLogoutRequest;
use App\Http\Controllers\Api\Auth\LoginDomain\LoginController;
use App\Http\Controllers\Api\Auth\LoginDomain\Contracts\LoginContract;


class LoginControllerTest extends TestCase
{
    use DatabaseMigrations;
    private $controller;
    private $retriever;
    private $classPath = '\App\Http\Controllers\Api\Auth\LoginDomain\LoginController';

    public function setUp()
    {
        parent::setUp();
        $this->retriever = Mockery::mock(LoginContract::class);
        $this->controller = new LoginController($this->retriever);
    }

    /**
     * A Mockery Test for get_param in ClockIn Contoller
     *
     * @return array
     */
    public function test_get_param()
    {
        $input = ["username" => "tes3t@email.com", "password" => "tes3t@email.com"];
        $request = new LoginLogoutRequest($input);

        $function = 'getParam';

        $method = $this->get_private_method($this->classPath, $function);

        $response = $method->invoke($this->controller, $request);

        $this->assertEquals($response, $input);
        $this->assertArrayHasKey('username', $input);
        $this->assertArrayHasKey('password', $input);
        $this->assertInternalType('array', $response);
    }


    /**
     * A Mockery Test for Login Contoller
     *
     * @return json
     */
    public function test_login_controller_with_mockery()
    {
        $username = "tes3t@email.com";
        $password = "tes3t@email.com";

        $expectedResponse = [
            "token_type" => "Bearer", "expires_in" => 31536000, "access_token" => "serializedToken", "refresh_token" => "serializedToken"
        ];

        $this->retriever
            ->shouldReceive('login')
            ->with($username, $password)
            ->once()->andReturn($expectedResponse);

        $response = $this->retriever->login($username, $password);

        $this->assertEquals($expectedResponse, $response);
    }

    public function test_login_controller_fails_with_wrong_parameters()
    {
      $input = ["username" => "not_a_email", "password" => "tes3t@email.com"];
      $request = new LoginLogoutRequest($input);

      $expected = 'username is not a email!';


        $this->retriever
            ->shouldReceive('login')
            ->with($input['username'], $input['password'])
            ->once()->andReturn('username is not a email!');

        $response = $this->controller->login($request);

        $this->assertEquals($expected, $response);
    }

    public function test_login_controller_fails_with_bad_route_request()
    {
        $input = [
          "username" => "bad_email",
          "password" => "",
          "password_confirmation" => ""
        ];

        $response = $this->json('POST', "/api/login", $input);
        $response = $response->getOriginalContent();
        $expected = [
          "message" => "The given data was invalid.",
          "errors" => [
            "username" => [
              0 => "Username must be an email!"
            ],
            "password" => [
              0 => "Invalid username or password."
            ]
          ]
        ];

        $this->assertEquals($expected, $response);
    }
}
