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

        $totalHours = $this->clockOutModelRepo->getHours($clockIn->carbon, $clockOut->carbon);


        return $this->clockOutModelRepo->appendClockOutToTimeLog($timeLog, $clockOut, $totalHours);
    }
}
