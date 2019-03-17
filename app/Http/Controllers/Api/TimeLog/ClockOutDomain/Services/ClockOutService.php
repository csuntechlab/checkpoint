<?php 

namespace App\Http\Controllers\Api\TimeLog\ClockOutDomain\Services;

// Auth
use Illuminate\Support\Facades\Auth;

// Contracts 
use App\Http\Controllers\Api\TimeLog\Logic\Contracts\ClockOutLogicContract;
use App\Http\Controllers\Api\TimeLog\ClockOutDomain\Contracts\ClockOutContract;

class ClockOutService implements ClockOutContract
{

    protected $clockOutLogic;

    public function __construct(ClockOutLogicContract $clockOutLogicUtility)
    {
        $this->clockOutLogicUtility = $clockOutLogicUtility;
    }

    public function clockOut(string $timeStamp, string $logUuid)
    {
        $user = Auth::user();

        $timelog = $this->clockOutLogicUtility->getTimeLog($user, $logUuid);
        
        $clockOut = $this->clockOutLogicUtility->getClockOut($timeStamp);         

        return $this->clockOutLogicUtility->appendClockOutToTimeLog($timelog, $clockOut);
    }

}

 