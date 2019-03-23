<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

use function Opis\Closure\unserialize;

// Models
use App\Models\TimeLog;

// Service
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
        $this->seed('ProgramSeeder');
        $this->seed('UsersTableSeeder');
        $this->seed('TimeSheetSeeder');
        $this->user = \App\User::where('id', 1)->first();
        $this->actingAs($this->user);
    }

    public function test_getTimeLog_passes()
    {
        $expectedResponse = factory(TimeLog::class)->create();
        $expectedResponse->user_id = $this->user->id;
        $expectedResponse->clock_out = null;
        $expectedResponse->save();

        $response = $this->service->getTimeLog($this->user->id, $expectedResponse->id);

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

    public function test_getTimeLog_throws_AlreadyClockedOutException()
    {
        $this->expectException('App\Exceptions\TimeLogExceptions\ClockOut\AlreadyClockedOut');

        $expectedResponse = factory(TimeLog::class)->create();
        $expectedResponse->save();
        $this->service->getTimeLog($this->user->id, $expectedResponse->id);
    }

    public function test_getTimeLog_throws_TimeLogNotFoundException()
    {
        $this->expectException('App\Exceptions\TimeLogExceptions\TimeLogNotFound');
        $uuid = 'uuid';
        $this->service->getTimeLog($this->user->id, $uuid);
    }

    public function test_getClockOut_passes()
    {
        $date = "2019-02-01";
        $time = "06:30:44";
        $response = $this->service->getClockOut($date, $time);
        $this->assertInstanceOf('App\DomainValueObjects\TimeLog\ClockOut\ClockOut', $response);
    }

    public function test_appendClockOutToTimeLog_passes()
    {
        $timeLog = factory(TimeLog::class)->create();
        $clockOut =  $timeLog->clock_out;
        $clockOut = unserialize($clockOut);
        $date = "2019-02-01";
        $time = "06:30:44";

        $timeLog->user_id = $this->user->id;
        $timeLog->clock_out = null;
        $timeLog->save();

        $timeSheetId = $timeLog->time_sheet_id;
        $uuid = $timeLog->id;

        $expectedResponse = [
            "message_success" => "Clock out was successfull",
            "time_sheet_id" => $timeSheetId,
            "log_id" => $uuid,
            "date" => $date,
            "time" => $time,
        ];

        $response = $this->service->appendClockOutToTimeLog($timeLog, $clockOut, $date, $time);

        $this->assertEquals($expectedResponse, $response);
    }
}
