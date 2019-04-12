<?php

namespace App\Services;

// Auth
use Illuminate\Support\Facades\Auth;

// Contracts 
use App\Contracts\ClockOutContract;
use App\ModelRepositoryInterfaces\TImeLogClockOutModelRepositoryInterface;
use function GuzzleHttp\json_decode;
use App\DomainValueObjects\TimeLog\TimeStamp\TimeStamp;
use Carbon\Carbon;
use App\Exceptions\TimeLogExceptions\ClockOut\ClockOutWasNotSucessfullyAdded;

class ClockOutService implements ClockOutContract
{

    protected $clockOutModelRepo;

    public function __construct(TImeLogClockOutModelRepositoryInterface $clockOutModelRepo)
    {
        $this->clockOutModelRepo = $clockOutModelRepo;
    }

    public function clockOut(string $date, string $time, string $logId): array
    {
        $user = Auth::user();

        $timeLog = $this->clockOutModelRepo->getTimeLog($user->id, $logId);

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
