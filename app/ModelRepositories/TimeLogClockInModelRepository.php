<?php
namespace App\ModelRepositories;

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
use App\Exceptions\TimeLogExceptions\ClockIn\ClockInWasNotSuccesfullyAdded;

//Contracts
use App\ModelRepositoryInterfaces\TimeLogClockInModelRepositoryInterface;

class TimeLogClockInModelRepository implements TimeLogClockInModelRepositoryInterface
{

    private $domainName = "TimeLog";

    public function userHasIncompleteTimeLogByDate(string $date, string $userId): bool
    {
        try {
            $hasUserTimeLogged = TimeLog::where('user_id', $userId)->where('date', $date)->where('clock_out', null)->get();
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

    private function getClockIn(string $date, string $time): ClockIn
    {
        $timeStamp = new TimeStamp(new UUID('timeStamp'), $date, $time);
        $clockIn = new ClockIn(new UUID('clockIn'), $timeStamp);
        return $clockIn;
    }

    public function getTimeLogParam(string $userId, string $date, string $time): array
    {
        $logParam = array();

        $logParam['timeSheetId'] = $this->getTimeSheetId($userId);

        $id = new UUID($this->domainName);
        $logParam['id'] = $id->toString;

        $logParam['clockIn'] = $this->getClockIn($date, $time);

        return $logParam;
    }

    public function createClockInEntry(
        string $id,
        string $userId,
        string $organizationId,
        string $timeSheetId,
        ClockIn $clockIn,
        string $date,
        string $time
    ): array
    {
        try {
            TimeLog::create([
                'id' => $id,
                'user_id' => $userId,
                'organization_id' => $organizationId,
                'time_sheet_id' => $timeSheetId,
                'date' => $date,
                'clock_in' => serialize($clockIn),
            ]);
        } catch (\Exception $e) {
            throw new ClockInWasNotSuccesfullyAdded;
        }

        return [
            "message_success" => "Clock in was successful",
            "time_sheet_id" => $timeSheetId,
            "log_id" => $id,
            "date" => $date,
            "time" => $time
        ];
    }
}
