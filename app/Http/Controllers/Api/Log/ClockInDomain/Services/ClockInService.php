<?php 
// declare (strict_types = 1);
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

    private function verifyUserHasNotYetLogged($user)
    {    
        $hasUserLogged = Logs::where('user_id', 1)->where('clock_out',null)->get();
        if($hasUserLogged->count()!=0){
            throw new AlreadyClockedIn();
        }
    }
    
    public function clockIn($currentLocation, $timeStamp)
    {
        $user = Auth::user();

        $this->verifyUserHasNotYetLogged($user);
        
        $userInfo = $this->timePuncherRetriever->getUserLocationAndUserTimeSheetId($user, $currentLocation);
        
        $timeStamp = new TimeStamp(new UUID('timeStamp'), $timeStamp);
        
        $clockIn = new ClockIn(new UUID('clockIn'), $timeStamp, $userInfo['location']);

        $uuid = new UUID($this->domainName);

        try {
            $user = Logs::create([
                'id' => $uuid->toString,
                'user_id' => $user->id,
                'time_sheet_id' => $userInfo['timeSheetId'],
                'clock_in' => serialize($clockIn),
            ]);
        } catch (Illuminate\Database\QueryException $e) {
            return ['message_error' => 'Clock In was not successfully created.'];
        }
        
        return ["message_success" => "Clock in was successfull", "log_uuid" => $uuid->toString];  
    }
    
}

 