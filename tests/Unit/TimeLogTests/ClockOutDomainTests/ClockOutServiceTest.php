<?php

namespace Tests\Feature;

use Tests\TestCase;

use Mockery;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;

use App\Models\TimeLog;

use App\Http\Controllers\Api\TimeLog\Logic\Contracts\ClockOutLogicContract;
use App\Http\Controllers\Api\TimeLog\ClockOutDomain\Services\ClockOutService;

use function Opis\Closure\unserialize;

class ClockOutServiceTest extends TestCase
{
    use DatabaseMigrations;
    private $clockOutLogicUtility;
    private $service;
    private $classPath = 'App\Http\Controllers\Api\TimeLog\ClockOutDomain\Services\ClockOutService';
    private $user;

    public function setUp()
    {
        parent::setUp();
        $this->clockOutLogicUtility = Mockery::mock(ClockOutLogicContract::class);
        $this->service = new ClockOutService($this->clockOutLogicUtility);
        $this->seed('OrgnaizationSeeder');
        $this->seed('UsersTableSeeder');
        $this->seed('TimeSheetSeeder');
        $this->seed('TimeLogSeeder');
        $this->user = \App\User::where('id', 1)->first();
        $this->actingAs($this->user);
    }

    /**
     * Clock In test 
     *
     * @return void
     */
    public function test_clock_out_service()
    {
        $timeLog = TimeLog::first();
        $clockOut = unserialize($timeLog->clock_out);
        dd($clockOut);
        $timeStamp = "2019-02-01 06:30:44";
        $logUuid = "uuid";

        $expectedResponse = [
            "message_success" => "Clock out was successfull",
            "time_stamp" => $timeStamp
        ];

        $this->retriever
            ->shouldReceive('getTimeLog')
            ->with($this->user, $logUuid)
            ->once()->andReturn($expectedResponse);

        // dd($this->service);

        $response = $this->service->clockOut($timeStamp, $logUuid);
        dd($response);

        $this->assertEquals($expectedResponse, $response);
    }

    // public function test_get_log_param()
    // {
    //     $timeStamp =  "2019-02-01 06:30:44";

    //     $function = 'getClockOut';

    //     $method = $this->get_private_method($this->classPath, $function);

    //     $response = $method->invoke($this->service, $timeStamp);

    //     $this->assertInstanceOf('App\DomainValueObjects\TimeLog\ClockOut\ClockOut', $response);
    // }

    // public function test_get_time_log()
    // {
    //     $expectedResponse = factory(TimeLog::class)->create();
    //     $expectedResponse->clock_out = null;
    //     $expectedResponse->save();

    //     $function = 'getTimeLog';

    //     $method = $this->get_private_method($this->classPath, $function);

    //     $response = $method->invoke($this->service, $this->user, $expectedResponse->id);

    //     $responseId = $response->id;
    //     $responseUserId = $response->user_id;
    //     $responseTimeSheetId = $response->time_sheet_id;
    //     $responseClockIn = $response->clock_in;
    //     $responseClockOut = $response->clock_out;
    //     $responseTimeLogChangeStack = $response->log_change_stack;

    //     $expectedResponseId = $expectedResponse->id;
    //     $expectedResponseUserId = $expectedResponse->user_id;
    //     $expectedResponseTimeSheetId = $expectedResponse->time_sheet_id;
    //     $expectedResponseClockIn = $expectedResponse->clock_in;
    //     $expectedResponseClockOut = $expectedResponse->clock_out;
    //     $expectedResponseTimeLogChangeStack = $expectedResponse->log_change_stack;


    //     $this->assertEquals($expectedResponseId, $responseId);
    //     $this->assertEquals($expectedResponseUserId, $responseUserId);
    //     $this->assertEquals($expectedResponseTimeSheetId, $responseTimeSheetId);
    //     $this->assertEquals($expectedResponseClockIn, $responseClockIn);
    //     $this->assertEquals($expectedResponseClockOut, $responseClockOut);
    //     $this->assertEquals($expectedResponseTimeLogChangeStack, $responseTimeLogChangeStack);
    // }

    // public function test_get_log_fails_log_is_null()
    // {
    //     $this->expectException('App\Exceptions\TimeLogExceptions\ClockOut\AlreadyClockedOut');

    //     $function = 'getTimeLog';

    //     $method = $this->get_private_method($this->classPath, $function);

    //     $method->invoke($this->service, $this->user, 'wrong_uuid');
    // }

    // public function test_get_log_fails_log_is_not_null()
    // {
    //     $this->expectException('App\Exceptions\TimeLogExceptions\ClockOut\AlreadyClockedOut');

    //     $expectedResponse = factory(TimeLog::class)->create();
    //     $expectedResponse->save();

    //     $function = 'getTimeLog';

    //     $method = $this->get_private_method($this->classPath, $function);

    //     $response = $method->invoke($this->service, $this->user, $expectedResponse->id);
    // }
}
