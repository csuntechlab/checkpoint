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

    public function getHours(Carbon $clockIn, Carbon $clockOut): float
    {
        $hours = $clockIn->diffInRealHours($clockOut);
        return $hours;
    }

    public function appendClockOutToTimeLog(TimeLog $timeLog, TimeStamp $clockOut, float $totalHours): array
    {

        $clockOut = $clockOut->toArray();
        $date = $clockOut['date'];
        $time = $clockOut['time'];

        try {
            $timeLog->clock_out = json_encode($clockOut);
            $timeLog->save();
        } catch (\Exception $e) {
            throw new ClockOutWasNotSucessfullyAdded();
        }

        $timeSheetId = $timeLog->time_sheet_id;
        $log_id = $timeLog->id;

        return [
            "message_success" => "Clock out was successful",
            "time_sheet_id" => $timeSheetId,
            "log_id" => $log_id,
            "date" => $date,
            "time" => $time,
            'total_hours' => $totalHours
        ];
    }
}
