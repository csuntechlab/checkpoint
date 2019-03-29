<?php

namespace Tests\Feature;

use Tests\TestCase;

use Mockery;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;

// DomainValue Objects
use App\DomainValueObjects\UUIDGenerator\UUID;
use App\DomainValueObjects\TimeLog\ClockIn\ClockIn;
use App\DomainValueObjects\TimeLog\TimeStamp\TimeStamp;

use App\Http\Controllers\Api\TimeLog\Logic\Contracts\ClockInLogicContract;
use App\Http\Controllers\Api\TimeLog\ClockInDomain\Services\ClockInService;

class ClockInServiceTest extends TestCase
{
    use DatabaseMigrations;
    private $clockInLogicUtility;
    private $service;
    private $classPath = 'App\Http\Controllers\Api\TimeLog\ClockInDomain\Services\ClockInService';
    private $user;

    public function setUp()
    {
        parent::setUp();
        $this->clockInLogicUtility = Mockery::mock(ClockInLogicContract::class);
        $this->service = new ClockInService($this->clockInLogicUtility);
        $this->seed('OrgnaizationSeeder');
        $this->seed('ProgramSeeder');
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
        $userId = $this->user->id;

        $date = "2019-02-01";
        $time = "06:30:44";

        $timeStamp = new TimeStamp(new UUID('timeStamp'), $date, $time);
        $clockIn = new ClockIn(new UUID('clockIn'), $timeStamp);

        $timeSheetId = "id";
        $logUuid = "id";

        $expectedLogParam = [
            "timeSheetId" => $timeSheetId,
            "id" => $logUuid,
            "clockIn" => $clockIn
        ];

        $expectedResponse = [
            "message_success" => "Clock in was successful",
            "timeSheet_id" => $timeSheetId,
            "log_id" => $logUuid,
            "date" => $date,
            "time" => $time
        ];

        $this->clockInLogicUtility
            ->shouldReceive('userHasIncompleteTimeLogByDate')
            ->with($date, $userId)
            ->once()->andReturn(true);

        $this->clockInLogicUtility
            ->shouldReceive('getTimeLogParam')
            ->with($userId, $date, $time)
            ->once()->andReturn($expectedLogParam);

        $this->clockInLogicUtility
            ->shouldReceive('createClockInEntry')
            ->with($logUuid, $userId, $timeSheetId, $clockIn, $date, $time)
            ->once()->andReturn($expectedResponse);

        $response = $this->service->clockIn($date, $time);

        $this->assertEquals($expectedResponse, $response);
    }
}
