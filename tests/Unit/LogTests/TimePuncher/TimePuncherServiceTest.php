<?php

namespace Tests\Feature;

use Tests\TestCase;

use Mockery;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;

use App\Http\Controllers\Api\Log\TimePuncher\Services\TimePuncherService;

class TimePuncherServiceTest extends TestCase
{
    use DatabaseMigrations;
    private $service;
    private $classPath = 'App\Http\Controllers\Api\Log\TimePuncher\Services\TimePuncherService';
    private $user;

    public function setUp()
    {
        parent::setUp();
        $this->service = new TimePuncherService();
        $this->seed('OrgnaizationSeeder');
        $this->seed('UsersTableSeeder');
        $this->seed('TimeSheetSeeder');

        $this->user = \App\User::where('id', 1)->first();
        $this->actingAs($this->user);
    }

    public function test_get_user_location_user_time_sheet_id()
    {
        $currentLocation = "blob";

        $response = $this->service->getUserLocationAndUserTimeSheetId($this->user, $currentLocation);

        $this->assertInternalType('array', $response);
        $this->assertArrayHasKey('location', $response);
        $this->assertArrayHasKey('timeSheetId', $response);
        $this->assertInstanceOf('App\DomainValueObjects\Location\Location', $response['location']);
    }

    public function test_get_user_location()
    {
        $currentLocation = "blob";

        $response = $this->service->getUserLocation($this->user, $currentLocation);
        $this->assertInstanceOf('App\DomainValueObjects\Location\Location', $response);
    }

    public function test_verify_user_location()
    {
        $currentLocation = "blob";

        $function = 'verifyUserLocation';

        $method = $this->get_private_method($this->classPath, $function);

        $response = $method->invoke($this->service, $this->user, $currentLocation);

        $this->assertInstanceOf('App\DomainValueObjects\Location\Location', $response);
    }

    public function test_get_user_profile()
    {
        $function = 'getUserProfile';

        $method = $this->get_private_method($this->classPath, $function);

        $response = $method->invoke($this->service, $this->user);

        $this->assertInstanceOf('App\DomainValueObjects\UserProfile\UserProfile', $response);
    }

    public function test_get_time_sheet()
    {
        $function = 'getTimeSheet';

        $method = $this->get_private_method($this->classPath, $function);

        $response = $method->invoke($this->service, $this->user);

        $this->assertInstanceOf('App\TimeSheets', $response);
    }
}
