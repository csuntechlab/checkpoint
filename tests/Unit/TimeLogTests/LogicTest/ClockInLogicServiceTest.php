<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

// DomainValue Objects
use App\DomainValueObjects\UUIDGenerator\UUID;
use App\DomainValueObjects\TimeLog\ClockIn\ClockIn;
use App\DomainValueObjects\TimeLog\TimeStamp\TimeStamp;

// Models
use App\Models\TimeSheets;
use App\Models\TimeLog;

use App\Http\Controllers\Api\TimeLog\Logic\Services\ClockInLogicService;

class ClockInLogicServiceTest extends TestCase
{

    use DatabaseMigrations;
    private $clockInLogicUtility;
    private $service;
    private $classPath = 'App\Http\Controllers\Api\TimeLog\Logic\Services\ClockInLogicService';
    private $user;

    public function setUp()
    {
        parent::setUp();
        $this->service = new ClockInLogicService();
        $this->seed('OrgnaizationSeeder');
        $this->seed('ProgramSeeder');
        $this->seed('UsersTableSeeder');
        $this->seed('TimeSheetSeeder');
        $this->seed('TimeLogSeeder');
        $this->user = \App\User::where('id', 1)->first();
        $this->actingAs($this->user);
    }

    public function test_verifyUserHasNotYetTimeLogged_passes()
    {
        $date = "2019-02-01";

        $response = $this->service->checkIfIncompleteTimeLogOnThisDate($date, $this->user->id);

        $this->assertInternalType('bool', $response);
        $this->assertEquals(true, $response);
    }

    public function test_verifyUserHasNotYetTimeLogged_throws_AlreadyClockedIn_exception()
    {
        $this->expectException('App\Exceptions\TimeLogExceptions\ClockIn\AlreadyClockedIn');

        $userId = 1;

        $timeLog = factory(TimeLog::class)->create();
        $timeLog->user_id = $userId;
        $timeLog->clock_out = null;
        $timeLog->save();

        $date = "2019-02-01";

        $function = 'checkIfIncompleteTimeLogOnThisDate';
        $method = $this->get_private_method($this->classPath, $function);
        $response = $method->invoke($this->service, $date, $userId);
    }

    public function test_getTmeSheetId_passes()
    {
        $userId = 1;
        $timeSheet = TimeSheets::where('user_id', $userId)->first();

        $function = 'getTimeSheetId';
        $method = $this->get_private_method($this->classPath, $function);
        $response = $method->invoke($this->service, $userId);

        $this->assertEquals($timeSheet->id, $response);
        $this->assertInternalType('string', $response);
    }

    public function test_getTmeSheetId_throws_TimeSheetNotFound_exception()
    {

        $this->expectException('App\Exceptions\TimeSheetExceptions\TimeSheetNotFound');
        $userId = 1;

        TimeSheets::where('user_id', $userId)->first()->delete();

        $function = 'getTimeSheetId';
        $method = $this->get_private_method($this->classPath, $function);
        $response = $method->invoke($this->service, $userId);
    }

    public function test_getClockIn_passes()
    {
        $date = "2019-02-01";
        $time = "06:30:44";

        $function = 'getClockIn';
        $method = $this->get_private_method($this->classPath, $function);
        $response = $method->invoke($this->service, $date, $time);

        $this->assertInstanceOf('App\DomainValueObjects\TimeLog\ClockIn\ClockIn', $response);
    }

    public function test_getTimeLogParam_passes()
    {
        $date = "2019-02-01";
        $time = "06:30:44";

        $response = $this->service->getTimeLogParam($this->user->id, $date, $time);

        $this->assertArrayHasKey('clockIn', $response);
        $this->assertArrayHasKey('id', $response);
        $this->assertArrayHasKey('timeSheetId', $response);
        $this->assertInternalType('string', $response['id']);
        $this->assertInstanceOf('App\DomainValueObjects\TimeLog\ClockIn\ClockIn', $response['clockIn']);
    }

    public function test_createClockInEntry_passes()
    {
        $date = "2019-02-01";
        $time = "06:30:44";

        $timeStamp = new TimeStamp(new UUID('timeStamp'), $date, $time);
        $clockIn = new ClockIn(new UUID('clockIn'), $timeStamp);

        $timeSheetId = "id";
        $logUuid = "id";

        $response = $this->service->createClockInEntry($logUuid, $this->user->id, $timeSheetId, $clockIn, $date, $time);

        $this->assertArrayHasKey('message_success', $response);
        $this->assertArrayHasKey('time_sheet_id', $response);
        $this->assertArrayHasKey('log_id', $response);
        $this->assertArrayHasKey('date', $response);
        $this->assertArrayHasKey('time', $response);
        $this->assertInternalType('string', $response['message_success']);
        $this->assertInternalType('string', $response['time_sheet_id']);
        $this->assertInternalType('string', $response['log_id']);
        $this->assertInternalType('string', $response['date']);
        $this->assertInternalType('string', $response['time']);
    }
}
