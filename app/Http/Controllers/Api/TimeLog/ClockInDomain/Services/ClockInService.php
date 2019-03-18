<?php 
namespace App\Http\Controllers\Api\TimeLog\ClockInDomain\Services;

// Auth
use Illuminate\Support\Facades\Auth;

// Contracts
use App\Http\Controllers\Api\TimeLog\ClockInDomain\Contracts\ClockInContract;
use App\Http\Controllers\Api\TimeLog\Logic\Contracts\ClockInLogicContract;

class ClockInService implements ClockInContract
{
    protected $clockInLogicUtility;

    public function __construct(ClockInLogicContract $clockInLogicUtility)
    {
        $this->clockInLogicUtility = $clockInLogicUtility;
    }

    public function clockIn(string $timeStamp): array
    {
        $user = Auth::user();
        $userId = $user->id;

        $this->clockInLogicUtility->verifyUserHasNotYetTimeLogged($userId);
        
        $logParam = $this->clockInLogicUtility->getTimeLogParam($userId, $timeStamp);

        return $this->clockInLogicUtility->createClockInEntry($logParam['uuid'], $userId, $logParam['timeSheetId'], $logParam['clockIn'], $timeStamp);
    }
    
}

 