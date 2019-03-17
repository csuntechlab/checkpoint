<?php 
namespace App\Http\Controllers\Api\TimeLog\Logic\Services;

// Domain Value Object

use App\DomainValueObjects\UUIDGenerator\UUID;
use App\DomainValueObjects\TimeLog\ClockOut\ClockOut;
use App\DomainValueObjects\TimeLog\TimeStamp\TimeStamp;

//Models
use App\Models\TimeLog;

//Exceptions 
use App\Exceptions\TimeLogExceptions\TimeLogNotFound;
use App\Exceptions\GeneralExceptions\DataBaseQueryFailed;
use App\Exceptions\TimeLogExceptions\ClockOut\AlreadyClockedOut;
// Contracts 
use App\Http\Controllers\Api\TimeLog\Logic\Contracts\ClockOutLogicContract;
use function Opis\Closure\serialize;

class ClockOutLogicService implements ClockOutLogicContract
{
    private $domainName = "clockOut";

    public function getTimeLog($userId, $logUuid)
    {
        try {
            $log = TimeLog::where('id', $logUuid)->where('user_id', $userId)->first();
        } catch (\Exception $e) {
            $subject = 'TimeLog ';
            throw new DataBaseQueryFailed($subject);
        }

        if ($log == null) throw new TimeLogNotFound();

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

    public function appendClockOutToTimeLog($timeLog, ClockOut $clockOut, string $timeStamp)
    {
        try {
            $timeLog->clock_out = serialize($clockOut);
            $timeLog->save();
        } catch (\Exception $e) {
            return ['message_error' => 'Clock Out was not successfully created.'];
        }
        return ["message_success" => "Clock out was successfull", "time_stamp" => $timeStamp];
    }
}
