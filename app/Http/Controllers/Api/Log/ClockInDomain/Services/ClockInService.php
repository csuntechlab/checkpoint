<?php 
declare (strict_types = 1);
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

    private function verifyUserHasNotYetLogged()
    {
        $user = Auth::user();

        $hasUserLogged = Logs::where('user_id', 1)->where('clock_out',null)->get();

        // if check hasUserLoggedNull
        
        if($hasUserLogged->count()!=0){
            throw new AlreadyClockedIn();
        }
        
        return $user;
    }

    private function getLogParam($userInfo, $timeStamp): array
    {
        $logParam = array();
        
        $logParam['uuid'] = new UUID($this->domainName);

        $timeStamp = new TimeStamp(new UUID('timeStamp'), $timeStamp);
        
        $logParam['clockIn'] = new ClockIn(new UUID('clockIn'), $timeStamp, $userInfo['location']);
        
        $logParam['timeStamp'] = $timeStamp;
        
        return $logParam;
    }
    
    public function clockIn($currentLocation, $timeStamp)
    {
        $user = $this->verifyUserHasNotYetLogged();
        
        $userInfo = $this->timePuncherRetriever->getUserLocationAndUserTimeSheetId($user, $currentLocation);
        
        $logParam = $this->getLogParam($userInfo,$timeStamp);

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

 