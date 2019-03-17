<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

// Models
use App\Models\TimeLog;

// Contracts
use App\Http\Controllers\Api\TimeLog\Logic\Services\ClockOutLogicService;


class ClockOutLogicServiceTest extends TestCase
{
    use DatabaseMigrations;
    private $service;
    private $classPath = 'App\Http\Controllers\Api\TimeLog\Logic\Services\ClockOutLogicService';
    private $user;

    public function setUp()
    {
        parent::setUp();
        $this->service = new ClockOutLogicService();
        $this->seed('OrgnaizationSeeder');
        $this->seed('UsersTableSeeder');
        $this->seed('TimeSheetSeeder');
        $this->user = \App\User::where('id', 1)->first();
        $this->actingAs($this->user);
    }

    public function test_get_time_log()
    {
        $expectedResponse = factory(TimeLog::class)->create();
        $expectedResponse->user_id = $this->user->id;
        $expectedResponse->clock_out = null;
        $expectedResponse->save();

        $response = $this->service->getTimeLog($this->user, $expectedResponse->id);

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

        $this->assertInstanceOf('App\Models\TimeLog', $response);
    }

    public function test_get_time_log_throws_Already_Clocked_Out_Exception()
    {
        $this->expectException('App\Exceptions\TimeLogExceptions\ClockOut\AlreadyClockedOut');

        $expectedResponse = factory(TimeLog::class)->create();
        $expectedResponse->save();
        $this->service->getTimeLog($this->user, $expectedResponse->id);
    }

    public function test_get_time_log_throws_Time_Log_Not_Found_Exception()
    {
        $this->expectException('App\Exceptions\TimeLogExceptions\TimeLogNotFound');
        $uuid = 'uuid';
        $this->service->getTimeLog($this->user, $uuid);
    }


    // public function test_get_time_log_throws_database_query_failed()
    // {
    //     $this->expectException('App\Exceptions\GeneralExceptions\DataBaseQueryFailed');
    //     $uuid = 'uuid';
    //     $this->service->getTimeLog($this->user, $uuid);
    // }
}
