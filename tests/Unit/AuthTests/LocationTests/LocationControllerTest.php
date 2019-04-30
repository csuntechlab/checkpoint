<?php

namespace Tests\Feature;

use Tests\TestCase;
// use Illuminate\Foundation\Teclearsting\WithFaker;
// use Illuminate\Foundation\Testing\RefreshDatabase;

use Mockery;
use App\DomainValueObjects\Location\Address;

use Illuminate\Http\Request;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Http\Controllers\LocationController;
use App\Contracts\LocationContract;

class LocationControllerTest extends TestCase
{
  use DatabaseMigrations;
  private $controller;
  private $retriever;

  public function setUp()
  {
    parent::setUp();
    $this->retriever = Mockery::mock(LocationContract::class);
    $this->controller = new LocationController($this->retriever);
    $this->seed('PassportSeeder');
    $this->seed('TimeCalculatorTypeSeeder');
    $this->seed('PayPeriodTypeSeeder');
    $this->seed('OrganizationSeeder');
    $this->seed('RoleSeeder');
    $this->seed('UsersTableSeeder');
    $this->user = \App\User::where('id', 1)->first();
    $this->actingAs($this->user);
  }

  public function test_add_organization_location()
  {
    $request = [
      'longitude' => 42.09,
      'latitude' => 48.03,
      'radius' => 5,
      'address_number' => "9423 #A",
      'street' => "Reseda Blvd",
      'city' => "Northridge",
      'state' => "California",
      'zip' => "91324",
    ];

    $latitude = $request['latitude'];
    $longitude = $request['longitude'];
    $radius = $request['radius'];

    $address = new Address(
      $request['address_number'],
      $request['street'],
      $request['city'],
      $request['state'],
      $request['zip']
    );

    $expectedResponse = [];

    $this->retriever
      ->shouldReceive('addOrganizationLocation')
      ->with($address, $longitude, $latitude, $radius)
      ->once()
      ->andReturn($expectedResponse);

    $response = $this->retriever->addOrganizationLocation($address, $longitude, $latitude, $radius);

    $this->assertEquals($expectedResponse, $response);
  }

  public function test_add_project_location()
  {
    $request = [
      'id' => "some_project_id",
      'longitude' => 42.09,
      'latitude' => 48.03,
      'radius' => 5,
      'address_number' => "9423 #A",
      'street' => "Reseda Blvd",
      'city' => "Northridge",
      'state' => "California",
      'zip' => "91324",
    ];

    $latitude = $request['latitude'];
    $longitude = $request['longitude'];
    $radius = $request['radius'];
    $id = $request['id'];

    $address = new Address(
      $request['address_number'],
      $request['street'],
      $request['city'],
      $request['state'],
      $request['zip']
    );

    $expectedResponse = [];
    $this->retriever
      ->shouldReceive('addProjectLocation')
      ->with($address, $longitude, $latitude, $radius, $id)
      ->once()
      ->andReturn($expectedResponse);

    $response = $this->retriever->addProjectLocation($address, $longitude, $latitude, $radius, $id);

    $this->assertEquals($expectedResponse, $response);
  }

  public function test_add_location_http_call_for_organization()
  {
    $request = [
      'longitude' => 42.09,
      'latitude' => 48.03,
      'radius' => 5,
      'address_number' => "9423 #A",
      'street' => "Reseda Blvd",
      'city' => "Northridge",
      'state' => "California",
      'zip' => "91324",
    ];

    $token = $this->get_auth_token($this->user);


    $response = $this->withHeaders([
      'Accept' => 'application/json',
      'Content-Type' => 'application/x-www-form-urlencoded',
      'Authorization' => $token
    ])->json('POST', '/api/add/location', $request)->getOriginalContent();

    $id = $response->id;
    $response = json_encode($response);

    $expectedResponse = [
      'id' => $id,
      'address' =>  "9423 #A\\tReseda Blvd\\tNorthridge\\tCalifornia\\t91324",
      'lat' => 48.03,
      'lng' => 42.09,
      'radius' => 5
    ];

    $expectedResponse = json_encode($expectedResponse);

    $this->assertEquals($response, $expectedResponse);
  }
}
