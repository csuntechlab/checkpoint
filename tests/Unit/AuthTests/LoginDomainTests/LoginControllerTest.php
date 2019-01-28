<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Mockery;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\Auth\LoginDomain\LoginController;
use App\Http\Controllers\Api\Auth\LoginDomain\Contracts\LoginContract;

class LoginControllerTest extends TestCase
{
    private $controller;
    private $retriever;

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
    public function test_logout_controller_with_mockery()
    {
        $input = ["username" => "tes3t@email.com", "password" => "tes3t@email.com"];

        $request = new Request($input);

        $expectedResponse = [
            "token_type" => "Bearer", "expires_in" => 31536000, "access_token" => "serializedToken", "refresh_token" => "serializedToken"
        ];

        $this->retriever
            ->shouldReceive('login')
            ->with($request)
            ->once()->andReturn($expectedResponse);

        $response = $this->retriever->login($request);

        $this->assertEquals($expectedResponse, $response);
    }
}
