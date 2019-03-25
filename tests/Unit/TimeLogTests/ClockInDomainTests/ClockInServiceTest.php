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
        $this->seed('OrganizationSeeder');
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

        $timeStampString = "2019-02-01 06:30:44";

        $timeStamp = new TimeStamp(new UUID('timeStamp'), $timeStampString);
        $clockIn = new ClockIn(new UUID('clockIn'), $timeStamp);

        $timeSheetId = "uuid";
        $logUuid = "uuid";

        $logParam = [
            "timeSheetId" => $timeSheetId,
            "uuid" => $logUuid,
            "clockIn" => $clockIn
        ];

        $expectedResponse = [
            "message_success" => "Clock in was successfull",
            "timeSheet_id" => $timeSheetId,
            "log_uuid" => $logUuid,
            "time_stamp" => $timeStampString
        ];

        $this->clockInLogicUtility
            ->shouldReceive('verifyUserHasNotYetTimeLogged')
            ->with($userId)
            ->once()->andReturn(true);

        $this->clockInLogicUtility
            ->shouldReceive('getTimeLogParam')
            ->with($userId, $timeStampString)
            ->once()->andReturn($logParam);

        $this->clockInLogicUtility
            ->shouldReceive('createClockInEntry')
            ->with($logUuid, $userId, $timeSheetId, $clockIn, $timeStampString)
            ->once()->andReturn($expectedResponse);

        $response = $this->service->clockIn($timeStampString);

        $this->assertEquals($expectedResponse, $response);
    }
}
