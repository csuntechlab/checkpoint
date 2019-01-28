<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Mockery;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\Auth\RegisterDomain\Contracts\RegisterContract;
use App\Http\Controllers\Api\Auth\RegisterDomain\RegisterController;

class RegisterControllerTest extends TestCase
{
    private $controller;
    private $retriever;

    public function setUp()
    {
        parent::setUp();
        $this->retriever = Mockery::mock(RegisterContract::class);
        $this->controller = new RegisterController($this->retriever);
    }


    /**
     * A Mockery Test for Register Contoller
     *
     * @return userCreds
     */
    public function test_register_controller_with_mockery()
    {
        $input = [
            "name" => "tes3t@email.com",
            "email" => "tes3t@email.com",
            "password" => "tes3t@email.com",
            "password_confirmation" => "tes3t@email.com"
        ];

        $request = new Request($input);

        $expectedResponse = [
            "name" => "tes3t@email.com",
            "email" => "tes3t@email.com",
            "updated_at" => "2019-01-28 17:55:46",
            "created_at" => "2019-01-28 17:55:46",
            "id" => 3
        ];

        $this->retriever
            ->shouldReceive('register')
            ->with($request)
            ->once()->andReturn($expectedResponse);

        $response = $this->retriever->register($request);

        $this->assertEquals($expectedResponse, $response);
    }
}
