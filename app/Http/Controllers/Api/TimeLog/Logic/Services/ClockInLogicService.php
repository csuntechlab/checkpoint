<?php 
namespace App\Http\Controllers\Api\TimeLog\Logic\Services;

use function Opis\Closure\serialize;

// DomainValue Objects
use App\DomainValueObjects\UUIDGenerator\UUID;
use App\DomainValueObjects\TimeLog\ClockIn\ClockIn;
use App\DomainValueObjects\TimeLog\TimeStamp\TimeStamp;

// TB Models
use App\Models\TimeSheets;
use App\Models\TimeLog;

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
    public function verifyUserHasNotYetTimeLogged($userId): bool
    {
        $userId = 1;

        try {
            $hasUserTimeLogged = TimeLog::where('user_id', $userId)->where('clock_out', null)->get();
        } catch (\Exception $e) {
            $subject = 'TimeLog ';
            throw new DataBaseQueryFailed($subject);
        }

        if ($hasUserTimeLogged->count() != 0) {
            throw new AlreadyClockedIn();
        }

        return true;
    }

    //TODO: hard Code fix
    private function getTimeSheetId($userId): string
    {
        $userId = 1;

        try {
            $timeSheet = TimeSheets::where('user_id', $userId)->first();
        } catch (Illuminate\Database\QueryException $e) {
            $subject = 'Time Sheet ';
            throw new DataBaseQueryFailed($subject);
        }

        if ($timeSheet == null || $timeSheet->count() == 0) throw new TimeSheetNotFound();

        return $timeSheet->id;
    }

    public function getTimeLogParam($userId, $timeStamp): array
    {
        $logParam = array();

        $logParam['timeSheetId'] = $this->getTimeSheetId($userId);

        $uuid = new UUID($this->domainName);
        $logParam['uuid'] = $uuid->toString;

        $timeStamp = new TimeStamp(new UUID('timeStamp'), $timeStamp);

        $logParam['clockIn'] = new ClockIn(new UUID('clockIn'), $timeStamp);

        return $logParam;
    }

    public function createClockInEntry(string $uuid, $userId, string $timeSheetId, ClockIn $clockIn, string $timeStamp)
    {
        try {
            TimeLog::create([
                'id' => $uuid,
                'user_id' => $userId,
                'time_sheet_id' => $timeSheetId,
                'clock_in' => serialize($clockIn),
            ]);
        } catch (Illuminate\Database\QueryException $e) {
            return ['message_error' => 'Clock In was not successfully created.'];
        }

        return [
            "message_success" => "Clock in was successfull",
            "log_uuid" => $uuid,
            "time_stamp" => $timeStamp
        ];
    }
}
