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
    private $userId = "uuid";
    private $classPath = 'App\Http\Controllers\Api\TimeLog\Logic\Services\ClockInLogicService';

    public function setUp()
    {
        parent::setUp();
        $this->service = new ClockInLogicService();
    }

    public function test_verifyUserHasNotYetTimeLogged_fails_throws_DataBaseQueryFailed_exception()
    {
        $this->expectException('App\Exceptions\GeneralExceptions\DataBaseQueryFailed');

        $response = $this->service->verifyUserHasNotYetTimeLogged($this->userId);
    }

    public function test_getTmeSheetId_passes()
    {
        $this->expectException('App\Exceptions\GeneralExceptions\DataBaseQueryFailed');

        $function = 'getTimeSheetId';
        $method = $this->get_private_method($this->classPath, $function);
        $response = $method->invoke($this->service, $this->userId);
    }


    // public function test_createClockInEntry_fails_throws_DataBaseQueryFailed_exception()
    // {
    //     $this->expectException('App\Exceptions\TimeLogExceptions\ClockIn\ClockInWasNotSuccesfullyAdded');

    //     $timeStampString = "2019-02-01 06:30:44";

    //     $timeStamp = new TimeStamp(new UUID('timeStamp'), $timeStampString);
    //     $clockIn = new ClockIn(new UUID('clockIn'), $timeStamp);

    //     $timeSheetId = "uuid";
    //     $logUuid = "uuid";
    //     // dd($this->userId);
    //     $response = $this->service->createClockInEntry($logUuid, $this->userId, $timeSheetId, $clockIn, $timeStampString);
    // }
}
