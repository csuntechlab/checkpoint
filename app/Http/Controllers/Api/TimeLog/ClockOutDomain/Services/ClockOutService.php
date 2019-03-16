<?php 
namespace App\Http\Controllers\Api\TimeLog\ClockOutDomain\Services;

use function Opis\Closure\serialize;

// Auth
use Illuminate\Support\Facades\Auth;

// TB Models
use App\TimeLog;

//Exceptions 
use App\Exceptions\TimeLogExceptions\ClockOut\AlreadyClockedOut;
// Contracts 
use App\Http\Controllers\Api\TimeLog\ClockOutDomain\Contracts\ClockOutContract;
use App\Http\Controllers\Api\TimeLog\Logic\Contracts\ClockOutLogicContract;

class ClockOutService implements ClockOutContract
{

    protected $clockOutLogic;

    public function __construct(ClockOutLogicContract $clockOutLogic)
    {
        $this->clockOutLogic = $clockOutLogic;
    }

    public function clockOut(string $timeStamp, string $logUuid)
    {
        $user = Auth::user();

        $log = $this->clockOutLogic->getTimeLog($user, $logUuid);
        
        $clockOut = $this->clockOutLogic->getClockOut($timeStamp);         

        try {
            $log->clock_out = serialize($clockOut);
            $log->save();
        } catch (Illuminate\Database\QueryException $e) {
            return ['message_error' => 'Clock Out was not successfully created.'];
        }
        return ["message_success" => "Clock out was successfull"];  
    }

}

 