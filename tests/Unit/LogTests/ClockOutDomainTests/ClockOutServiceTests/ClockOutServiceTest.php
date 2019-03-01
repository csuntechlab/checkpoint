<?php

namespace Tests\Feature;

use Tests\TestCase;

use Mockery;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;

use App\Http\Controllers\Api\Log\TimePuncher\Contracts\TimePuncherContract;
use App\Http\Controllers\Api\Log\ClockOutDomain\Services\ClockOutService;

class ClockOutServiceTest extends TestCase
{
    use DatabaseMigrations;
    private $retriever;
    private $service;
    private $classPath = 'App\Http\Controllers\Api\Log\ClockOutDomain\Services\ClockOutService';
    private $user;

    public function setUp()
    {
        parent::setUp();
        $this->retriever = Mockery::mock(TimePuncherContract::class);
        $this->service = new ClockOutService($this->retriever);
        $this->seed('OrgnaizationSeeder');
        $this->seed('UsersTableSeeder');
        $this->seed('TimeSheetSeeder');

        $this->user = \App\User::where('id', 1)->first();
        $this->actingAs($this->user);
    }

    /**
     * Clock In test 
     *
     * @return void
     */
    public function test_clock_in_service_get_user_location_and_user_time_sheet_id_with_mockery()
    {
        $currentLocation = "blob";

        $expectedResponse = [
            "message_success" => "Clock in was successfull",
            "log_uuid" => "uuid"
        ];

        $this->retriever
            ->shouldReceive('getUserLocation')
            ->with($this->user, $currentLocation)
            ->once()->andReturn($expectedResponse);

        $response = $this->retriever->getUserLocation($this->user, $currentLocation);

        $this->assertEquals($expectedResponse, $response);
    }

    public function test_get_log_param()
    {
        $userProfile = unserialize($this->user->user_profile);

        $userLocation = $userProfile->getProfileLocation();

        $timeStamp =  "2019-02-01 06:30:44";

        $function = 'getLogParam';

        $method = $this->get_private_method($this->classPath, $function);

        $response = $method->invoke($this->service, $userLocation, $timeStamp);

        $this->assertInstanceOf('App\DomainValueObjects\Log\ClockOut\ClockOut', $response);
    }

    public function test_get_log()
    {
        // create log faactory
    }
}
