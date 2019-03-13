<?php 
namespace App\Http\Controllers\Api\TimeLog\ClockOutDomain\Services;

use function Opis\Closure\serialize;

// Auth
use Illuminate\Support\Facades\Auth;

// Domain Value Object
use App\DomainValueObjects\UUIDGenerator\UUID;
use App\DomainValueObjects\TimeLog\ClockOut\ClockOut;
use App\DomainValueObjects\TimeLog\TimeStamp\TimeStamp;
// TB Models
use App\TimeLog;

//Exceptions 
use App\Exceptions\TimePuncherExceptions\ClockOut\AlreadyClockedOut;
// Contracts 
use App\Http\Controllers\Api\TimeLog\ClockOutDomain\Contracts\ClockOutContract;
use App\Http\Controllers\Api\TimeLog\TimePuncher\Contracts\TimePuncherContract;
class ClockOutService implements ClockOutContract
{
    private $domainName = "clockOut";

    protected $timePuncherRetriever;

    public function __construct(TimePuncherContract $timePuncherContract)
    {
        $this->timePuncherRetriever = $timePuncherContract;
    }

    private function getTimeLog($logUuid){
        $log = TimeLog::where('id', $logUuid)->first();

        if ($log == null) throw new AlreadyClockedOut();

        if ($log->clock_out != null) throw new AlreadyClockedOut();
        
        return $log;
    }

    private function getTimeLogParam($userLocation,$timeStamp)
    {
        $timeStamp = new TimeStamp(new UUID('timeStamp'), $timeStamp);

        $clockOutUUid = new UUID($this->domainName);

        $clockOut = new ClockOut($clockOutUUid, $timeStamp, $userLocation);

        return $clockOut;
    }

    public function clockOut(string $currentLocation, string $timeStamp, string $logUuid)
    {
        $user = Auth::user();
        
        $log = $this->getTimeLog($logUuid);
        
        $userLocation = $this->timePuncherRetriever->getUserLocation($user, $currentLocation);

        $clockOut = $this->getTimeLogParam($userLocation, $timeStamp);         
        try {
            $log->clock_out = serialize($clockOut);
            $log->save();
        } catch (Illuminate\Database\QueryException $e) {
            return ['message_error' => 'Clock Out was not successfully created.'];
        }
        return ["message_success" => "Clock out was successfull"];  
    }

}

 