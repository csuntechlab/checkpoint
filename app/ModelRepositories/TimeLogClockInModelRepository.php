<?php
namespace App\ModelRepositories;

// DomainValue Objects
use App\DomainValueObjects\UUIDGenerator\UUID;
use App\DomainValueObjects\TimeLog\ClockIn\ClockIn;
use App\DomainValueObjects\TimeLog\TimeStamp\TimeStamp;

// TB Models
use App\Models\TimeSheet;
use App\Models\TimeLog;

//Exceptions
use App\Exceptions\TimeSheetExceptions\TimeSheetNotFound;
use App\Exceptions\GeneralExceptions\DataBaseQueryFailed;
use App\Exceptions\TimeLogExceptions\ClockIn\AlreadyClockedIn;
use App\Exceptions\TimeLogExceptions\ClockIn\ClockInWasNotSuccessfullyAdded;

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

    //TODO: hard Code fix  we should be passing in orgId and Time Sheet Id
    public function getTimeSheet(string $organizationId): TimeSheet
    {
        try {
            $timeSheet = TimeSheet::where('organization_id', $organizationId)->first();
        } catch (\Exception $e) {
            $subject = 'Time Sheet ';
            throw new DataBaseQueryFailed($subject);
        }

        if ($timeSheet == null) throw new TimeSheetNotFound();

        return $timeSheet;
    }
}
