<?php

namespace Tests\Feature;

use Tests\TestCase;
use Mockery;
use Illuminate\Foundation\Testing\DatabaseMigrations;

// Models
use App\Models\TimeLog;

// Contracts
use App\Http\Controllers\Api\TimeLog\ClockOutDomain\Services\ClockOutService;
use App\Http\Controllers\Api\TimeLog\Logic\Contracts\ClockOutLogicContract;

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
        $this->seed('OrganizationSeeder');
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
    public function test_ClockOutService_passes()
    {
        $timeLog = factory(TimeLog::class)->create();
        $clockOut = unserialize($timeLog->clock_out);

        $date = "2019-02-01";
        $time = "06:30:44";

        $logUuid = $timeLog->id;

        $expectedResponse =  [
            "message_success" => "Clock out was successfull",
            "time_sheet_id" => "id",
            "log_id" => "id",
            "date" => $date,
            "time" => $time,
        ];

        $this->clockOutLogicUtility
            ->shouldReceive('getTimeLog')
            ->with($this->user->id, $logUuid)
            ->once()->andReturn($timeLog);

        $this->clockOutLogicUtility
            ->shouldReceive('getClockOut')
            ->with($date, $time)
            ->once()->andReturn($clockOut);

        $this->clockOutLogicUtility
            ->shouldReceive('appendClockOutToTimeLog')
            ->with($timeLog, $clockOut, $date, $time)
            ->once()->andReturn($expectedResponse);

        $response = $this->service->clockOut($date, $time, $logUuid);

        $this->assertEquals($expectedResponse, $response);
    }
}
