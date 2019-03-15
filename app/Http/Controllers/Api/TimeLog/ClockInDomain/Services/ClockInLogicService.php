<?php 
namespace App\Http\Controllers\api\TimeLog\ClockInDomain\Services;





// DomainValue Objects

use App\DomainValueObjects\UUIDGenerator\UUID;
use App\DomainValueObjects\TimeLog\ClockIn\ClockIn;
use App\DomainValueObjects\TimeLog\TimeStamp\TimeStamp;
// TB Models
use App\TimeLog;
use App\TimeSheets;

//Exceptions
use App\Exceptions\TimeSheetExceptions\TimeSheetNotFound;



class ClockLogicService implements ClockInLogicContract
{

    private $domainName = "TimeLog";

    //TODO: hard code fix
    public function verifyUserHasNotYetTimeLogged($userId)
    {
        $userId = 1;

        // add try catch
        $hasUserTimeLogged = TimeLog::where('user_id', $userId)->where('clock_out', null)->get();

        if ($hasUserTimeLogged->count() != 0 || $hasUserTimeLogged == null) {
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

    //TODO hard Code fix
    private function getTimeSheetId($user)
    {
        $userId = 1;

        try {
            $timeSheet = TimeSheets::where('user_id', $userId)->first();
        } catch (Illuminate\Database\QueryException $e) {
            throw new TimeSheetNotFound();
        }

        if ($timeSheet->count() != 0 || $timeSheet == null) {
            throw new TimeSheetNotFound();
        }

        return $timeSheet->id;
    }
}
