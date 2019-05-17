<?php

namespace App\Services;

use function GuzzleHttp\json_decode;
use Carbon\Carbon;

// Domain Value Objects
use App\DomainValueObjects\TimeLog\TimeStamp\TimeStamp;

// Models
use App\Models\TimeLog;

// Contracts 
use App\Contracts\ClockOutContract;

// Exceptions
use App\Exceptions\TimeLogExceptions\ClockOut\ClockOutWasNotSucessfullyAdded;

class ClockOutService implements ClockOutContract
{

    public function clockOut(string $date, string $time, TimeLog $timeLog): array
    {
        $clockIn = json_decode($timeLog->clock_in);

        $clockIn = new TimeStamp($clockIn->date, $clockIn->time);
        $clockOut = new TimeStamp($date, $time);

        $clockInCarbon = $clockIn->carbon;
        $clockOutCarbon = $clockOut->carbon;

        $totalHours =  $clockInCarbon->diffInRealHours($clockOutCarbon);

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
