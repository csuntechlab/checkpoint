<?php

namespace Tests\Feature;

use Tests\TestCase;

//Models 
use App\DomainValueObjects\UUIDGenerator\UUID;
use App\DomainValueObjects\TimeLog\ClockOut\ClockOut;
use App\DomainValueObjects\TimeLog\TimeStamp\TimeStamp;

// Service
use App\Http\Controllers\Api\TimeLog\Logic\Services\ClockOutLogicService;

class ClockOutLogicServiceNoDatabaseMigrationsTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->service = new ClockOutLogicService();
    }

    public function test_getTimeLog_throws_DataBaseQueryFailed()
    {
        $userId = 1;
        $this->expectException('App\Exceptions\GeneralExceptions\DataBaseQueryFailed');
        $uuid = 'uuid';
        $this->service->getTimeLog($userId, $uuid);
    }

    public function test_appendClockOutToTimeLog_ClockOutWasNotSuccesfullyCreated()
    {

        $timeStampString =  "2019-02-01 09:30:44";
        $clockOutUUid = new UUID("clockOut");
        $timeStamp = new TimeStamp(new UUID('timeStamp'), $timeStampString);
        $clockOut = new ClockOut($clockOutUUid, $timeStamp);
        $timeLog = "App\Models\TimeLog";

        $this->expectException('App\Exceptions\TimeLogExceptions\ClockOut\ClockOutWasNotSucessfullyAdded');
        $this->service->appendClockOutToTimeLog($timeLog, $clockOut, $timeStampString);
    }
}
