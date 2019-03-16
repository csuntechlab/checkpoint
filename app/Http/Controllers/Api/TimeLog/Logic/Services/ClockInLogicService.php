<?php 
namespace App\Http\Controllers\Api\TimeLog\Logic\Services;

// DomainValue Objects

use App\DomainValueObjects\UUIDGenerator\UUID;
use App\DomainValueObjects\TimeLog\ClockIn\ClockIn;
use App\DomainValueObjects\TimeLog\TimeStamp\TimeStamp;

// TB Models
use App\TimeSheets;

//Exceptions
use App\Exceptions\TimeSheetExceptions\TimeSheetNotFound;
use App\Exceptions\GeneralExceptions\DataBaseQueryFailed;
use App\Exceptions\TimeLogExceptions\ClockIn\AlreadyClockedIn;

//Contracts
use App\Http\Controllers\Api\TimeLog\Logic\Contracts\ClockInLogicContract;

class ClockInLogicService implements ClockInLogicContract
{

    private $domainName = "TimeLog";

    //TODO: hard Code fix
    public function verifyUserHasNotYetTimeLogged($userId)
    {
        $userId = 1;

        try {
            $hasUserTimeLogged = \App\TimeLog::where('user_id', $userId)->where('clock_out', null)->get();
        } catch (Illuminate\Database\QueryException $e) {
            $subject = 'TimeLog ';
            throw new DataBaseQueryFailed($subject);
        }

        if ($hasUserTimeLogged->count() != 0) {
            throw new AlreadyClockedIn();
        }

        return true;
    }

    public function getTimeLogParam($user, $timeStamp): array
    {
        $logParam = array();

        $logParam['timeSheetId'] = $this->getTimeSheetId($user);

        $logParam['uuid'] = new UUID($this->domainName);

        $timeStamp = new TimeStamp(new UUID('timeStamp'), $timeStamp);

        $logParam['clockIn'] = new ClockIn(new UUID('clockIn'), $timeStamp);

        return $logParam;
    }

    //TODO: hard Code fix
    private function getTimeSheetId($user)
    {
        $userId = 1;

        try {
            $timeSheet = TimeSheets::where('user_id', $userId)->first();
        } catch (Illuminate\Database\QueryException $e) {
            $subject = 'Time Sheet ';
            throw new DataBaseQueryFailed($subject);
        }

        if ($timeSheet == null || $timeSheet->count() == 0) {
            throw new TimeSheetNotFound();
        }

        return $timeSheet->id;
    }
}
