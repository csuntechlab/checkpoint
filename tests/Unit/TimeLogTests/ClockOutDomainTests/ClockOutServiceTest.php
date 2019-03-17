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
    public function test_ClockOutService_passes()
    {
        $timeLog = factory(TimeLog::class)->create();
        $clockOut = unserialize($timeLog->clock_out);

        $timeStampString = $clockOut->getTimeStamp()->getTimeStampString();
        $logUuid = $timeLog->id;

        $expectedResponse =  [
            "message_success" => "Clock out was successfull",
            "timeSheet_id" => "uuid",
            "log_uuid" => "uuid",
            "time_stamp" => $timeStampString
        ];

        $this->clockOutLogicUtility
            ->shouldReceive('getTimeLog')
            ->with($this->user->id, $logUuid)
            ->once()->andReturn($timeLog);

        $this->clockOutLogicUtility
            ->shouldReceive('getClockOut')
            ->with($timeStampString)
            ->once()->andReturn($clockOut);

        $this->clockOutLogicUtility
            ->shouldReceive('appendClockOutToTimeLog')
            ->with($timeLog, $clockOut, $timeStampString)
            ->once()->andReturn($expectedResponse);

        $response = $this->service->clockOut($timeStampString, $logUuid);

        $this->assertEquals($expectedResponse, $response);
    }
}
