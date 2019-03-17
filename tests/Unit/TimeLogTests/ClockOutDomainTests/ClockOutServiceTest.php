<?php

namespace Tests\Feature;

use Tests\TestCase;
use Mockery;
use Illuminate\Foundation\Testing\DatabaseMigrations;

// Models
use App\Models\TimeLog;

// Contracts
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
        $timeLog = factory(TimeLog::class)->create();
        $clockOut = unserialize($timeLog->clock_out);

        $timeStampString = $clockOut->getTimeStamp()->getTimeStampString();
        $logUuid = $timeLog->id;

        $expectedResponse = [
            "message_success" => "Clock out was successfull",
            "time_stamp" => $timeStampString
        ];

        $this->clockOutLogicUtility
            ->shouldReceive('getTimeLog')
            ->with($this->user, $logUuid)
            ->once()->andReturn($timeLog);

        $this->clockOutLogicUtility
            ->shouldReceive('getClockOut')
            ->with($timeStampString)
            ->once()->andReturn($clockOut);

        $this->clockOutLogicUtility
            ->shouldReceive('appendClockOutToTimeLog')
            ->with($timeLog, $clockOut)
            ->once()->andReturn($expectedResponse);

        $response = $this->service->clockOut($timeStampString, $logUuid);

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
