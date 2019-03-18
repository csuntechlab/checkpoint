<?php

namespace Tests\Feature;

use Tests\TestCase;
// use Illuminate\Foundation\Teclearsting\WithFaker;
// use Illuminate\Foundation\Testing\RefreshDatabase;

use Mockery;
use Illuminate\Http\Request;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Http\Controllers\Api\Auth\RegisterDomain\RegisterController;
use App\Http\Controllers\Api\Auth\RegisterDomain\Contracts\RegisterContract;

class RegisterControllerTest extends TestCase
{
    use DatabaseMigrations;
    private $controller;
    private $retriever;
    private $classPath = "\App\Http\Controllers\Api\Auth\RegisterDomain\RegisterController";

    public function setUp()
    {
        parent::setUp();
        $this->retriever = Mockery::mock(RegisterContract::class);
        $this->controller = new RegisterController($this->retriever);
        $this->seed('OrgnaizationSeeder');
    }

    /**
     * A Mockery Test for get_param in ClockIn Contoller
     *
     * @return array
     */
    public function test_get_param()
    {
        $input = [
            "name" => "tes3t@email.com",
            "email" => "tes3t@email.com",
            "password" => "tes3t@email.com",
            "password_confirmation" => "tes3t@email.com",
            "invite_code" => "000-000"
        ];

        $expectedResponse = [
            "name" => "tes3t@email.com",
            "email" => "tes3t@email.com",
            "password" => "tes3t@email.com",
            "invite_code" => "000-000"
        ];

        $request = new Request($input);

        $function = 'getParam';

        $method = $this->get_private_method($this->classPath, $function);

        $response = $method->invoke($this->controller, $request);

        $this->assertEquals($response, $expectedResponse);
        $this->assertArrayHasKey('name', $expectedResponse);
        $this->assertArrayHasKey('email', $expectedResponse);
        $this->assertArrayHasKey('password', $expectedResponse);
        $this->assertArrayHasKey('password', $expectedResponse);
        $this->assertArrayHasKey('invite_code', $response);
    }

    /**
     * A Mockery Test for Register Contoller
     *
     * @return userCreds
     */
    public function test_register_controller_with_mockery()
    {

        $name = "tes3t@email.com";
        $email = "tes3t@email.com";
        $password = "tes3t@email.com";
        $inviteCode = "000-000";

        $expectedResponse = [];

        $this->retriever
            ->shouldReceive('register')
            ->with($name, $email, $password, $inviteCode)
            ->once()->andReturn($expectedResponse);

        $response = $this->retriever->register($name, $email, $password, $inviteCode);

        $this->assertEquals($expectedResponse, $response);
    }

    public function test_register_http_call()
    {
        $input = [
            "name" => "tes3t@email.com",
            "email" => "tes3t@email.com",
            "password" => "tes3t@email.com",
            "password_confirmation" => "tes3t@email.com"
        ];

        $response = $this->json('POST', "/api/register", $input);
        $response = $response->getOriginalContent();
        $response = json_encode($response);
        $actualResponse = [
            "name" => "tes3t@email.com",
            "email" => "tes3t@email.com"
        ];
        $actualResponse = json_encode($actualResponse);
        $this->assertEquals($response, $actualResponse);
    }

    public function test_register_fails_with_wrong_parameters()
    {
      $input = [
          "name" => "tes3t@email.com",
          "email" => "not_a_email",
          "password" => "tes3t@email.com",
          "password_confirmation" => "tes3t@email.com"
      ];

      $response = $this->json('POST', "/api/register", $input);
      $response = $response->getOriginalContent();
      $expected = [0 => 'Not a valid email'];

      $this->assertEquals($expected, $response['errors']['email']);
    }
}
