<?php

namespace Tests\Feature;

use Tests\TestCase;

use Mockery;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;

use App\Http\Controllers\Api\TimeLog\TimePuncher\Contracts\TimePuncherContract;
use App\Http\Controllers\Api\TimeLog\ClockInDomain\Services\ClockInService;

class ClockInServiceTest extends TestCase
{
    use DatabaseMigrations;
    private $retriever;
    private $service;
    private $classPath = 'App\Http\Controllers\Api\TimeLog\ClockInDomain\Services\ClockInService';
    private $user;

    public function setUp()
    {
        parent::setUp();
        $this->retriever = Mockery::mock(TimePuncherContract::class);
        $this->service = new ClockInService($this->retriever);
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
        $user = "user";

        $expectedResponse = [
            "message_success" => "Clock in was successfull",
            "log_uuid" => "uuid"
        ];

        $this->retriever
            ->shouldReceive('getUserLocationAndUserTimeSheetId')
            ->with($user, $currentLocation)
            ->once()->andReturn($expectedResponse);

        $response = $this->retriever->getUserLocationAndUserTimeSheetId($user, $currentLocation);

        $this->assertEquals($expectedResponse, $response);
    }

    public function test_get_log_param()
    {
        $userProfile = unserialize($this->user->user_profile);

        $userLocation = $userProfile->getProfileLocation();

        $timeStamp =  "2019-02-01 06:30:44";

        $function = 'getTimeLogParam';

        $method = $this->get_private_method($this->classPath, $function);

        $response = $method->invoke($this->service, $userLocation, $timeStamp);

        $this->assertInstanceOf('App\DomainValueObjects\UUIDGenerator\UUID', $response['uuid']);
        $this->assertInstanceOf('App\DomainValueObjects\TimeLog\ClockIn\ClockIn', $response['clockIn']);
        $this->assertInstanceOf('App\DomainValueObjects\TimeLog\TimeStamp\TimeStamp', $response['timeStamp']);
    }

    public function test_verify_user_has_not_yet_logged()
    {
        $function = 'verifyUserHasNotYetTimeLogged';

        $method = $this->get_private_method($this->classPath, $function);

        $response = $method->invoke($this->service, $this->user->id);

        $this->assertEquals($response, true);
    }
}
