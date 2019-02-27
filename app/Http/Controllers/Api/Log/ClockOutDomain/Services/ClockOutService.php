<?php 
declare (strict_types = 1);
namespace App\Http\Controllers\Api\Log\ClockOutDomain\Services;

use function Opis\Closure\serialize;
use function Opis\Closure\unserialize;

// Auth
use Illuminate\Support\Facades\Auth;

// Domain Value Object
use App\DomainValueObjects\UUIDGenerator\UUID;
use App\DomainValueObjects\Log\ClockOut\ClockOut;
use App\DomainValueObjects\Log\TimeStamp\TimeStamp;

// TB Models
use App\Logs;
// Contracts 
use App\Http\Controllers\Api\Log\ClockOutDomain\Contracts\ClockOutContract;
use App\Http\Controllers\Api\Log\TimePuncher\Contracts\TimePuncherContract;
class ClockOutService implements ClockOutContract
{
    private $domainName = "clockOut";

    protected $timePuncherRetriever;

    public function __construct(TimePuncherContract $timePuncherContract)
    {
        $this->timePuncherRetriever = $timePuncherContract;
    }

    public function clockOut($request)
    {
        $currentLocation = (string)$request['location'];
        
        $timeStamp = (string)$request['timeStamp'];

        $logUuid = $request['logUuid'];

        $user = Auth::user();

        $log = Logs::where('id', $logUuid)->first();

        if ($log->clock_out != null) {
            return ['message_error' => 'User has already clocked out.'];
        }
        
        $userInfo = $this->timePuncherRetriever->getUserLocationAndUserTimeSheetId($user, $currentLocation);
        
        $timeStamp = new TimeStamp(new UUID('timeStamp'), $timeStamp);

        $clockOutUUid = new UUID($this->domainName);
        
        $clockOut = new ClockOut($clockOutUUid, $timeStamp, $userInfo['location']);
         
        try {
            $log->clock_out = serialize($clockOut);
            $log->save();
        } catch (Illuminate\Database\QueryException $e) {
            return ['message_error' => 'Clock Out was not successfully created.'];
        }

        return ["message_success" => "Clock out was successfull"];  
    }

}

 