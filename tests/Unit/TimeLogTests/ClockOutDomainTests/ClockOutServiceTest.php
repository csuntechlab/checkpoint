<?php

namespace Tests\Feature;

use Tests\TestCase;
use Mockery;
use Illuminate\Foundation\Testing\DatabaseMigrations;

// Models
use App\Models\TimeLog;

// Contracts
use App\Services\ClockOutService;
use App\ModelRepositoryInterfaces\TImeLogClockOutModelRepositoryInterface;

use function Opis\Closure\unserialize;
use App\DomainValueObjects\TimeLog\TimeStamp\TimeStamp;

class ClockOutServiceTest extends TestCase
{
    use DatabaseMigrations;
    private $clockOutLogicUtility;
    private $service;
    private $classPath = 'App\Services\ClockOutService';
    private $user;

    public function setUp()
    {
        parent::setUp();
        $this->clockOutLogicUtility = Mockery::mock(TImeLogClockOutModelRepositoryInterface::class);
        $this->service = new ClockOutService();
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
    public function test_ClockOutService_passes()
    {
        $timeLog = factory(TimeLog::class)->create();

        $date = "2019-02-01";
        $time = "06:30:44";

        $clockIn = json_decode($timeLog->clock_in);

        $clockIn = new TimeStamp($clockIn->date, $clockIn->time);
        $clockOut = new TimeStamp($date, $time);

        $totalHours = 20.19;

        $expectedResponse =  [
            "message_success" => "Clock out was successful",
            "time_sheet_id" => "id",
            "log_id" => "id",
            "date" => $date,
            "time" => $time,
        ];

        $response = $this->service->clockOut($date, $time, $timeLog);

        $this->assertArrayHasKey('message_success', $response);
        $this->assertArrayHasKey('time_sheet_id', $response);
        $this->assertArrayHasKey('log_id', $response);
        $this->assertArrayHasKey('date', $response);
        $this->assertArrayHasKey('time', $response);
    }
}
