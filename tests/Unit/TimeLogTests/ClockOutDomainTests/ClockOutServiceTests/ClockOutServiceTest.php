<?php

namespace Tests\Feature;

use Tests\TestCase;

use Mockery;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;

use App\TimeLog;

use App\Http\Controllers\Api\TimeLog\TimePuncher\Contracts\TimePuncherContract;
use App\Http\Controllers\Api\TimeLog\ClockOutDomain\Services\ClockOutService;

class ClockOutServiceTest extends TestCase
{
    use DatabaseMigrations;
    private $retriever;
    private $service;
    private $classPath = 'App\Http\Controllers\Api\TimeLog\ClockOutDomain\Services\ClockOutService';
    private $user;

    public function setUp()
    {
        parent::setUp();
        $this->retriever = Mockery::mock(TimePuncherContract::class);
        $this->service = new ClockOutService($this->retriever);
        $this->seed('OrgnaizationSeeder');
        $this->seed('UsersTableSeeder');
        $this->seed('TimeSheetSeeder');
        // $this->seed('TimeLogSeeder');
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
        $timeStamp =  "2019-02-01 06:30:44";

        $function = 'getClockOut';

        $method = $this->get_private_method($this->classPath, $function);

        $response = $method->invoke($this->service, $timeStamp);

        $this->assertInstanceOf('App\DomainValueObjects\TimeLog\ClockOut\ClockOut', $response);
    }

    public function test_get_time_log()
    {
        $expectedResponse = factory(TimeLog::class)->create();
        $expectedResponse->clock_out = null;
        $expectedResponse->save();

        $function = 'getTimeLog';

        $method = $this->get_private_method($this->classPath, $function);

        $response = $method->invoke($this->service, $this->user, $expectedResponse->id);

        $responseId = $response->id;
        $responseUserId = $response->user_id;
        $responseTimeSheetId = $response->time_sheet_id;
        $responseClockIn = $response->clock_in;
        $responseClockOut = $response->clock_out;
        $responseTimeLogChangeStack = $response->log_change_stack;

        $expectedResponseId = $expectedResponse->id;
        $expectedResponseUserId = $expectedResponse->user_id;
        $expectedResponseTimeSheetId = $expectedResponse->time_sheet_id;
        $expectedResponseClockIn = $expectedResponse->clock_in;
        $expectedResponseClockOut = $expectedResponse->clock_out;
        $expectedResponseTimeLogChangeStack = $expectedResponse->log_change_stack;


        $this->assertEquals($expectedResponseId, $responseId);
        $this->assertEquals($expectedResponseUserId, $responseUserId);
        $this->assertEquals($expectedResponseTimeSheetId, $responseTimeSheetId);
        $this->assertEquals($expectedResponseClockIn, $responseClockIn);
        $this->assertEquals($expectedResponseClockOut, $responseClockOut);
        $this->assertEquals($expectedResponseTimeLogChangeStack, $responseTimeLogChangeStack);
    }

    public function test_get_log_fails_log_is_null()
    {
        $this->expectException('App\Exceptions\TimePuncherExceptions\ClockOut\AlreadyClockedOut');

        $function = 'getTimeLog';

        $method = $this->get_private_method($this->classPath, $function);

        $method->invoke($this->service, $this->user, 'wrong_uuid');
    }

    public function test_get_log_fails_log_is_not_null()
    {
        $this->expectException('App\Exceptions\TimePuncherExceptions\ClockOut\AlreadyClockedOut');

        $expectedResponse = factory(TimeLog::class)->create();
        $expectedResponse->save();

        $function = 'getTimeLog';

        $method = $this->get_private_method($this->classPath, $function);

        $response = $method->invoke($this->service, $this->user, $expectedResponse->id);
    }
}
