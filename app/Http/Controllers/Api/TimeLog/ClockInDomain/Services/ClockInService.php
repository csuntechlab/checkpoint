<?php 
namespace App\Http\Controllers\Api\TimeLog\ClockInDomain\Services;

use function Opis\Closure\serialize;

// Auth
use Illuminate\Support\Facades\Auth;
// DomainValue Objects
use App\DomainValueObjects\UUIDGenerator\UUID;
use App\DomainValueObjects\TimeLog\ClockIn\ClockIn;
use App\DomainValueObjects\TimeLog\TimeStamp\TimeStamp;
// TB Models
use App\TimeLog;
use App\TimeSheets;

//Exception
use App\Exceptions\TimePuncherExceptions\ClockIn\AlreadyClockedIn;
// Contracts
use App\Http\Controllers\Api\TimeLog\ClockInDomain\Contracts\ClockInContract;
use App\Http\Controllers\Api\TimeLog\TimePuncher\Contracts\TimePuncherContract;

class ClockInService implements ClockInContract
{
    private $domainName = "TimeLog";

    protected $timePuncherRetriever;

    public function __construct(TimePuncherContract $timePuncherContract)
    {
        $this->timePuncherRetriever = $timePuncherContract;
    }

    //TODO: hard code fix
    private function verifyUserHasNotYetTimeLogged($userId)
    {
        $userId = 1;
        
        $hasUserTimeLogged = TimeLog::where('user_id', $userId)->where('clock_out',null)->get();
        
        if($hasUserTimeLogged->count()!=0 || $hasUserTimeLogged == null){
            throw new AlreadyClockedIn();
        }
        
        return true;
    }

    //TODO hard Code fix
    private function getTimeSheetId($user)
    {
        $userId = 1;
        //add try catch
        $timeSheet = TimeSheets::where('user_id', $userId)->first();
        
        return $timeSheet->id;
    }

    private function getTimeLogParam($user,$timeStamp): array
    {
        $logParam = array();

        $logParam['timeSheetId'] = $this->getTimeSheetId($user);
        
        $logParam['uuid'] = new UUID($this->domainName);

        $timeStamp = new TimeStamp(new UUID('timeStamp'), $timeStamp);
        
        $logParam['clockIn'] = new ClockIn(new UUID('clockIn'), $timeStamp);
        
        return $logParam;
    }

    public function clockIn(string $timeStamp)
    {
        $user = Auth::user();
        
        $this->verifyUserHasNotYetTimeLogged($user->id);
        
        $logParam = $this->getTimeLogParam($user, $timeStamp);

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

 