<?php 
namespace App\Http\Controllers\Api\TimeLog\Logic\Services;

use function Opis\Closure\serialize;

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
use App\Exceptions\TimeLogExceptions\ClockOut\ClockOutWasNotSucessfullyAdded;
// Contracts 
use App\Http\Controllers\Api\TimeLog\Logic\Contracts\ClockOutLogicContract;

class ClockOutLogicService implements ClockOutLogicContract
{
    private $domainName = "clockOut";

    public function getTimeLog(string $userId, string $logUuid): TimeLog
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

    public function getClockOut(string $date, $time): ClockOut
    {
        $clockOutUUid = new UUID($this->domainName);

        $timeStamp = new TimeStamp(new UUID('timeStamp'), $date, $time);

        $clockOut = new ClockOut($clockOutUUid, $timeStamp);

        return $clockOut;
    }

    public function appendClockOutToTimeLog(TimeLog $timeLog, ClockOut $clockOut, string $date, $time): array
    {
        try {
            $timeLog->clock_out = serialize($clockOut);
            $timeLog->save();
        } catch (\Exception $e) {
            throw new ClockOutWasNotSucessfullyAdded();
        }

        $timeSheetId = $timeLog->time_sheet_id;
        $id = $timeLog->id;

        return [
            "message_success" => "Clock out was successfull",
            "time_sheet_id" => $timeSheetId,
            "log_id" => $id,
            "date" => $date,
            "time" => $time
        ];
    }
}
