<?php 
namespace App\Http\Controllers\Api\TimeLog\ClockInDomain\Services;

// Auth
use Illuminate\Support\Facades\Auth;

// Contracts
use App\Http\Controllers\Api\TimeLog\ClockInDomain\Contracts\ClockInContract;
use App\Http\Controllers\Api\TimeLog\Logic\Contracts\ClockInLogicContract;

class ClockInService implements ClockInContract
{
    protected $clockInLogic;

    public function __construct(ClockInLogicContract $clockInLogic)
    {
        $this->clockInLogic = $clockInLogic;
    }

    public function clockIn(string $timeStamp): array
    {
        $user = Auth::user();
        $userId = $user->id;

        $this->clockInLogic->verifyUserHasNotYetTimeLogged($userId);
        
        $logParam = $this->clockInLogic->getTimeLogParam($userId, $timeStamp);

        return $this->clockInLogic->createClockInEntry($logParam['uuid'], $userId, $logParam['timeSheetId'], $logParam['clockIn'], $timeStamp);
    }
    
}

 