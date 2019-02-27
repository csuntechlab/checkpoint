<?php 
declare (strict_types = 1);
namespace App\Http\Controllers\Api\Log\ClockInDomain\Services;

use function Opis\Closure\serialize;
use function Opis\Closure\unserialize;

// Auth
use Illuminate\Support\Facades\Auth;
// DomainValue Objects
use App\DomainValueObjects\UUIDGenerator\UUID;
use App\DomainValueObjects\Log\ClockIn\ClockIn;
use App\DomainValueObjects\Log\TimeStamp\TimeStamp;
// TB Models
use App\Logs;
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

    public function clockIn($request)
    {
        $currentLocation = (string)$request['location'];
        
        $timeStamp = (string)$request['timeStamp'];

        $user = Auth::user();
        
        $userInfo = $this->timePuncherRetriever->getUserLocationAndUserTimeSheetId($user, $currentLocation);
        
        $timeStamp = new TimeStamp(new UUID('timeStamp'), $timeStamp);

        $clockInUuid = new UUID('clockIn');
        
        $clockIn = new ClockIn($clockInUuid, $timeStamp, $userInfo['location']);

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

 