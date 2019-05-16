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
use App\Models\Project;
use App\Models\UserRole;
use App\DomainValueObjects\UUIDGenerator\UUID;

class LocationControllerTest extends TestCase
{
  use DatabaseMigrations;
  private $controller;
  private $retriever;
  private $adminUser;

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
    $this->seed('ProjectSeeder'); // seeds also UserProject table
    $this->adminUser = \App\User::where('id', 1)->first();
    UserRole::create(['id' => UUID::generate(), 'user_id' => $this->adminUser->id, 'role_id' => 1]);
    $this->actingAs($this->adminUser);
  }

  public function test_update_organization_location()
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

    $organizationId = $this->adminUser->organization_id;

    $address = new Address(
      $request['address_number'],
      $request['street'],
      $request['city'],
      $request['state'],
      $request['zip']
    );

    $expectedResponse = [];

    $this->retriever
      ->shouldReceive('update')
      ->with($address, $longitude, $latitude, $radius, $organizationId)
      ->once()
      ->andReturn($expectedResponse);

    $response = $this->retriever->update($address, $longitude, $latitude, $radius, $organizationId);

    $this->assertEquals($expectedResponse, $response);
  }

  public function test_update_project_location()
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
    $project = Project::where('organization_id', $this->adminUser->organization_id)->first();

    $address = new Address(
      $request['address_number'],
      $request['street'],
      $request['city'],
      $request['state'],
      $request['zip']
    );

    $expectedResponse = [];
    $this->retriever
      ->shouldReceive('updateProjectLocation')
      ->with($address, $longitude, $latitude, $radius, $project)
      ->once()
      ->andReturn($expectedResponse);

    $response = $this->retriever->updateProjectLocation($address, $longitude, $latitude, $radius, $project);

    $this->assertEquals($expectedResponse, $response);
  }

  public function test_update_location_http_call_for_organization()
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

    $token = $this->get_auth_token($this->adminUser);


    $response = $this->withHeaders([
      'Accept' => 'application/json',
      'Content-Type' => 'application/x-www-form-urlencoded',
      'Authorization' => $token
    ])->json('POST', '/api/update/location', $request)->getOriginalContent();


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
