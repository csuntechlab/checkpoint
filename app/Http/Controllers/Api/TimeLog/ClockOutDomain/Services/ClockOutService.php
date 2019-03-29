<?php 

namespace App\Http\Controllers\Api\TimeLog\ClockOutDomain\Services;

// Auth
use Illuminate\Support\Facades\Auth;

// Contracts 
use App\Http\Controllers\Api\TimeLog\ClockOutDomain\Contracts\ClockOutContract;
use App\Http\Controllers\Api\TimeLog\Logic\Contracts\ClockOutLogicContract;

class ClockOutService implements ClockOutContract
{

    protected $clockOutLogicUtility;

    public function __construct(ClockOutLogicContract $clockOutLogicUtility)
    {
        $this->clockOutLogicUtility = $clockOutLogicUtility;
    }

    public function clockOut(string $date, string $time, string $logId): array
    {
        $user = Auth::user();

        $timelog = $this->clockOutLogicUtility->getTimeLog($user->id, $logId);
        
        $clockOut = $this->clockOutLogicUtility->getClockOut($date, $time);

        return $this->clockOutLogicUtility->appendClockOutToTimeLog($timelog, $clockOut, $date, $time);
    }

}

 