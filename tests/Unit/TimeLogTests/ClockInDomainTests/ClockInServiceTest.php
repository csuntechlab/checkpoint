<?php

namespace Tests\Feature;

use Tests\TestCase;
use Mockery;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;

// DomainValue Objects
use App\DomainValueObjects\TimeLog\TimeStamp\TimeStamp;

// Models
use App\Models\Organization;

// Interface
use App\ModelRepositoryInterfaces\TimeLogClockInModelRepositoryInterface;

// Service
use App\Services\ClockInService;
use App\Models\TimeSheet;

class ClockInServiceTest extends TestCase
{
    use DatabaseMigrations;
    private $clockInLogicUtility;
    private $service;
    private $classPath = 'App\Services\ClockInService';
    private $user;

    public function setUp()
    {
        parent::setUp();
        $this->clockInLogicUtility = Mockery::mock(TimeLogClockInModelRepositoryInterface::class);
        $this->service = new ClockInService($this->clockInLogicUtility);
        $this->seed('PassportSeeder');
        $this->seed('TimeCalculatorTypeSeeder');
        $this->seed('PayPeriodTypeSeeder');
        $this->seed('OrganizationSeeder');
        $this->seed('RoleSeeder');
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
        $userId = (string)$this->user->id;
        $orgId = (string)$this->user->organization_id;
        $date = "2019-02-01";
        $time = "06:30:44";

        $clockIn = new TimeStamp($date, $time);
        $timeSheetId = "id";
        $logUuid = "id";

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

        $timeSheet = TimeSheet::first();

        $this->clockInLogicUtility
            ->shouldReceive('getTimeSheet')
            ->with($orgId)
            ->once()->andReturn($timeSheet);

        $response = $this->service->clockIn($date, $time);

        $this->assertArrayHasKey('message_success', $response);
        $this->assertArrayHasKey('time_sheet_id', $response);
        $this->assertArrayHasKey('log_id', $response);
        $this->assertArrayHasKey('date', $response);
        $this->assertArrayHasKey('time', $response);
    }
}
