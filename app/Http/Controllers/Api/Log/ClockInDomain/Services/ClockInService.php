<?php 
namespace App\Http\Controllers\Api\Log\ClockInDomain\Services;

use function Opis\Closure\serialize;

// Auth
use Illuminate\Support\Facades\Auth;
// DomainValue Objects
use App\DomainValueObjects\UUIDGenerator\UUID;
use App\DomainValueObjects\Log\ClockIn\ClockIn;
use App\DomainValueObjects\Log\TimeStamp\TimeStamp;
// TB Models
use App\Logs;

//Exception
use App\Exceptions\TimePuncherExceptions\ClockIn\AlreadyClockedIn;
// Contracts
use App\Http\Controllers\Api\Log\ClockInDomain\Contracts\ClockInContract;
use App\Http\Controllers\Api\Log\TimePuncher\Contracts\TimePuncherContract;

class ClockInService implements ClockInContract
{
    private $domainName = "log";

    protected $timePuncherRetriever;

    public function __construct(TimePuncherContract $timePuncherContract)
    {
        $this->timePuncherRetriever = $timePuncherContract;
    }
    
    private function verifyUserHasNotYetLogged($userId)
    {
        $userId = 1;
        
        $hasUserLogged = Logs::where('user_id', 1)->where('clock_out',null)->get();
        
        if($hasUserLogged->count()!=0 || $hasUserLogged == null){
            throw new AlreadyClockedIn();
        }
        
        return true;
    }

    private function getLogParam($userLocation, $timeStamp): array
    {
        $logParam = array();
        
        $logParam['uuid'] = new UUID($this->domainName);

        $timeStamp = new TimeStamp(new UUID('timeStamp'), $timeStamp);
        
        $logParam['clockIn'] = new ClockIn(new UUID('clockIn'), $timeStamp, $userLocation);
        
        $logParam['timeStamp'] = $timeStamp;
        
        return $logParam;
    }
    
    public function clockIn(string $currentLocation, string $timeStamp)
    {
        $user = Auth::user();
        
        $this->verifyUserHasNotYetLogged($user->id);
        
        $userInfo = $this->timePuncherRetriever-> getUserLocationAndUserTimeSheetId($user, $currentLocation);
        
        $logParam = $this->getLogParam($userInfo[ 'location'], $timeStamp);

        $uuid = $logParam['uuid']->toString;

        try {
            $user = Logs::create([
                'id' => $uuid,
                'user_id' => $user->id,
                'time_sheet_id' => $userInfo['timeSheetId'],
                'clock_in' => serialize($logParam['clockIn']),
            ]);
        } catch (Illuminate\Database\QueryException $e) {
            return ['message_error' => 'Clock In was not successfully created.'];
        }
        
        return ["message_success" => "Clock in was successfull", "log_uuid" => $uuid];  
    }
    
}

 