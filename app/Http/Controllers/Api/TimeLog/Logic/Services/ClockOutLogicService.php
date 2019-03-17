<?php 
namespace App\Http\Controllers\Api\TimeLog\Logic\Services;

// Domain Value Object

use App\DomainValueObjects\UUIDGenerator\UUID;
use App\DomainValueObjects\TimeLog\ClockOut\ClockOut;
use App\DomainValueObjects\TimeLog\TimeStamp\TimeStamp;

//Models
use App\Models\TimeLog;

//Exceptions 
use App\Exceptions\TimeLogExceptions\ClockOut\AlreadyClockedOut;
// Contracts 
use App\Http\Controllers\Api\TimeLog\Logic\Contracts\ClockOutLogicContract;

class ClockOutLogicService implements ClockOutLogicContract
{
    private $domainName = "clockOut";

    public function getTimeLog($user, $logUuid)
    {
        // Try catch
        $log = TimeLog::where('id', $logUuid)->first();

        if ($log == null) throw new AlreadyClockedOut();

        if ($log->clock_out != null) throw new AlreadyClockedOut();

        return $log;
    }

    public function getClockOut($timeStamp)
    {
        $clockOutUUid = new UUID($this->domainName);

        $timeStamp = new TimeStamp(new UUID('timeStamp'), $timeStamp);

        $clockOut = new ClockOut($clockOutUUid, $timeStamp);

        return $clockOut;
    }
}
