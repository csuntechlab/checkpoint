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
use App\User;

//Exceptions
use App\Exceptions\TimeSheetExceptions\TimeSheetNotFound;
use App\Exceptions\GeneralExceptions\DataBaseQueryFailed;
use App\Exceptions\TimeLogExceptions\ClockIn\AlreadyClockedIn;

//Contracts
use App\Http\Controllers\Api\TimeLog\Logic\Contracts\ClockInLogicContract;
use App\Exceptions\TimeLogExceptions\ClockIn\ClockInWasNotSuccesfullyAdded;

class ClockInLogicService implements ClockInLogicContract
{

    private $domainName = "TimeLog";

    //TODO: hard Code fix
    public function verifyUserHasNotYetTimeLogged(string $userId): bool
    {
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
    private function getTimeSheetId(string $userId): string
    {
        try {
            $timeSheet = TimeSheets::where('user_id', $userId)->first();
        } catch (\Exception $e) {
            $subject = 'Time Sheet ';
            throw new DataBaseQueryFailed($subject);
        }

        if ($timeSheet == null) throw new TimeSheetNotFound();

        return $timeSheet->id;
    }

    private function getClockIn(string $timeStamp): ClockIn
    {
        $timeStamp = new TimeStamp(new UUID('timeStamp'), $timeStamp);
        $clockIn = new ClockIn(new UUID('clockIn'), $timeStamp);
        return $clockIn;
    }

    public function getTimeLogParam(string $userId, string $timeStamp): array
    {
        $logParam = array();

        $logParam['timeSheetId'] = $this->getTimeSheetId($userId);

        $uuid = new UUID($this->domainName);
        $logParam['uuid'] = $uuid->toString;

        $logParam['clockIn'] = $this->getClockIn($timeStamp);

        return $logParam;
    }

    public function createClockInEntry(string $uuid, string $userId, string $timeSheetId, ClockIn $clockIn, string $timeStamp): array
    {
        $organizationId = User::where('id', $userId)->first();
        $organizationId = $organizationId['organization_id'];
        try {
            TimeLog::create([
                'id' => $uuid,
                'user_id' => $userId,
                'organization_id' => $organizationId,
                'time_sheet_id' => $timeSheetId,
                'clock_in' => serialize($clockIn),
            ]);
        } catch (\Exception $e) {
            throw new ClockInWasNotSuccesfullyAdded;
        }

        return [
            "message_success" => "Clock in was successfull",
            "timeSheet_id" => $timeSheetId,
            "log_uuid" => $uuid,
            "time_stamp" => $timeStamp
        ];
    }
}
