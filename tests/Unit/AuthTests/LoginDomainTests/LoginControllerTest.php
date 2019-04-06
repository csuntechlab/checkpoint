<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

use Mockery;
use App\Http\Requests\Auth\LoginRequest;
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
     * A Mockery Test for Login Contoller
     *
     * @return json
     */
    public function test_login_controller_with_mockery()
    {
        $email = "tes3t@email.com";
        $password = "tes3t@email.com";

        $expectedResponse = [
            "token_type" => "Bearer",  "access_token" => "serializedToken"
        ];

        $this->retriever
            ->shouldReceive('login')
            ->with($email, $password)
            ->once()->andReturn($expectedResponse);

        $response = $this->retriever->login($email, $password);

        $this->assertEquals($expectedResponse, $response);
    }

    public function test_login_controller_fails_with_wrong_parameters()
    {
        $input = ["email" => "not_a_email", "password" => "tes3t@email.com"];
        $request = new LoginRequest($input);

        $expected = 'email is not a email!';


        $this->retriever
            ->shouldReceive('login')
            ->with($request['email'], $request['password'])
            ->once()->andReturn('email is not a email!');

        $response = $this->controller->login($request);

        $this->assertEquals($expected, $response);
    }

    public function test_login_controller_fails_with_bad_route_request()
    {
        $input = [
            "email" => "bad_email",
            "password" => "",
            "password_confirmation" => ""
        ];

        $response = $this->json('POST', "/api/login", $input);
        $response = $response->getOriginalContent();
        $expected = [
            "message" => "The given data was invalid.",
            "errors" => [
                "email" => [
                    0 => "Must use a valid email address."
                ],
                "password" => [
                    0 => "Invalid email or password."
                ]
            ]
        ];

        $this->assertEquals($expected, $response);
    }

    public function test_login_controller_fails_with_bad_email()
    {
        $input = [
            "email" => "michael.chann.hello@notaemail.com",
            "password" => "explorelearngobeyond",
            "password_confirmation" => "explorelearngobeyond"
        ];

        $response = $this->json('POST', "/api/login", $input);
        $response = $response->getOriginalContent();

        $expected = [
            "message" => "The given data was invalid.",
            "errors" => [
                "email" => [
                    0 => "Invalid email or password."
                ]
            ]
        ];

        $this->assertEquals($expected, $response);
    }
}
