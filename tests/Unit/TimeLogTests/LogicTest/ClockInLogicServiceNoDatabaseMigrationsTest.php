<?php

namespace Tests\Feature;

use Tests\TestCase;

// DomainValue Objects
use App\DomainValueObjects\UUIDGenerator\UUID;
use App\DomainValueObjects\TimeLog\ClockIn\ClockIn;
use App\DomainValueObjects\TimeLog\TimeStamp\TimeStamp;

// Models
use App\Models\TimeSheets;
use App\Models\TimeLog;

use App\Http\Controllers\Api\TimeLog\Logic\Services\ClockInLogicService;

class ClockInLogicServiceNoDatabaseMigrationsTest extends TestCase
{
    private $userId = "id";
    private $classPath = 'App\Http\Controllers\Api\TimeLog\Logic\Services\ClockInLogicService';

    public function setUp()
    {
        parent::setUp();
        $this->service = new ClockInLogicService();
    }

    public function test_verifyUserHasNotYetTimeLogged_fails_throws_DataBaseQueryFailed_exception()
    {
        $this->expectException('App\Exceptions\GeneralExceptions\DataBaseQueryFailed');
        $date = "2019-02-01";
        $response = $this->service->verifyTheUserDoesNotClockInWithOutResolvingThePreviousClockOutOnThisDate($date, $this->userId);
    }

    public function test_getTmeSheetId_passes()
    {
        $this->expectException('App\Exceptions\GeneralExceptions\DataBaseQueryFailed');

        $function = 'getTimeSheetId';
        $method = $this->get_private_method($this->classPath, $function);
        $response = $method->invoke($this->service, $this->userId);
    }


    public function test_createClockInEntry_fails_throws_DataBaseQueryFailed_exception()
    {
        $this->expectException('App\Exceptions\TimeLogExceptions\ClockIn\ClockInWasNotSuccesfullyAdded');

        $date = "2019-02-01";
        $time = "06:30:44";

        $timeStamp = new TimeStamp(new UUID('timeStamp'), $date, $time);
        $clockIn = new ClockIn(new UUID('clockIn'), $timeStamp);

        $timeSheetId = "id";
        $logUuid = "id";

        $response = $this->service->createClockInEntry($logUuid, $this->userId, $timeSheetId, $clockIn, $date, $time);
    }
}
