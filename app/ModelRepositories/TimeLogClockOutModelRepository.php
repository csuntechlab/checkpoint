<?php
namespace App\ModelRepositories;

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
use App\ModelRepositoryInterfaces\TImeLogClockOutModelRepositoryInterface;
use function GuzzleHttp\json_encode;
use Carbon\Carbon;

class TimeLogClockOutModelRepository implements TImeLogClockOutModelRepositoryInterface
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
}
