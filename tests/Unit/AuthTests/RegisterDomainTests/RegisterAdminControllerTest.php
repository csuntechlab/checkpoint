<?php

namespace Tests\Feature;

use Tests\TestCase;
// use Illuminate\Foundation\Teclearsting\WithFaker;
// use Illuminate\Foundation\Testing\RefreshDatabase;

use Mockery;
use Illuminate\Http\Request;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Http\Controllers\Api\Auth\RegisterDomain\RegisterAdminController;
use App\Http\Controllers\Api\Auth\RegisterDomain\Contracts\RegisterAdminContract;

class RegisterAdminControllerTest extends TestCase
{
  use DatabaseMigrations;
  private $controller;
  private $retriever;
  private $classPath = "\App\Http\Controllers\Api\Auth\RegisterDomain\RegisterAdminController";

  public function setUp()
  {
      parent::setUp();
      $this->retriever = Mockery::mock(RegisterAdminContract::class);
      $this->controller = new RegisterAdminController($this->retriever);
      $this->seed('OrgnaizationSeeder');
  }

  public function test_register()
  {
    $request = [
      'first_name' => "Mike",
      'last_name' => "Chann",
      'address_number' => "9423",
      'street'=> "Reseda Blvd",
      'city' => "Northridge",
      'state' => "CA",
      'zip' => "91324",
      'organization_name' => "META+LAB",
      'logo' => "logo.jpg",
      'email' => "MikaruuChann69@email.com",
      'password' => "A_password"
    ];

    $expectedResponse = [];


    $this->retriever
        ->shouldReceive('register')
        ->with($request)
        ->once()
        ->andReturn($expectedResponse);

    $response = $this->retriever->register($request);

    $this->assertEquals($expectedResponse, $response);

  }

  public function test_registerAdmin_http_call()
  {
    $request = [
      'first_name' => "Mike",
      'last_name' => "Chann",
      'address_number' => "9423",
      'street'=> "Reseda Blvd",
      'city' => "Northridge",
      'state' => "CA",
      'zip_code' => "91324",
      'country' => "United States",
      'organization_name' => "META+LAB",
      'email' => "MikaruuChann69@email.com",
      'logo' => "logo.jpg",
      'password' => "A_password",
      'password_confirmation' => "A_password"
    ];

    $response = $this->json('POST', "/api/register_admin", $request);
    $response = $response->getOriginalContent();
    $response = json_encode($response);
    $expectedResponse = [
      'organization' => [
        'organization_name' => "META+LAB",
        'logo' => "logo.jpg"
      ],
      'user' => [
        'name' => "Mike Chann",
        'email' => "MikaruuChann69@email.com",
      ]
    ];
    $expectedResponse = json_encode($expectedResponse);
    $this->assertEquals($response, $expectedResponse);
  }
}
