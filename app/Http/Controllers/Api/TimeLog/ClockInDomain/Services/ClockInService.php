<?php 
namespace App\Http\Controllers\Api\TimeLog\ClockInDomain\Services;

use function Opis\Closure\serialize;

// Auth
use Illuminate\Support\Facades\Auth;

//Models
use App\TimeLog;

// Contracts
use App\Http\Controllers\Api\TimeLog\ClockInDomain\Contracts\ClockInContract;
use App\Http\Controllers\Api\TimeLog\ClockInDomain\Contracts\ClockInLogicContract;

class ClockInService implements ClockInContract
{
    protected $clockInLogic;

    public function __construct(ClockInLogicContract $clockInLogic)
    {
        $this->clockInLogic = $clockInLogic;
    }

    public function clockIn(string $timeStamp)
    {
        $user = Auth::user();

        $this->clockInLogic->verifyUserHasNotYetTimeLogged($user->id);
        
        $logParam = $this->clockInLogic->getTimeLogParam($user, $timeStamp);

        $uuid = $logParam['uuid']->toString;

        try {
            $user = TimeLog::create([
                'id' => $uuid,
                'user_id' => $user->id,
                'time_sheet_id' => $logParam['timeSheetId'],
                'clock_in' => serialize($logParam['clockIn']),
            ]);
        } catch (Illuminate\Database\QueryException $e) {
            return ['message_error' => 'Clock In was not successfully created.'];
        }
        
        return ["message_success" => "Clock in was successfull", "log_uuid" => $uuid];  
    }
    
}

 