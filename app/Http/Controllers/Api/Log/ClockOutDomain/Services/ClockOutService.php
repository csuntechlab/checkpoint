<?php 
declare (strict_types = 1);
namespace App\Http\Controllers\Api\Log\ClockOutDomain\Services;

use function Opis\Closure\serialize;
use function Opis\Closure\unserialize;

use Illuminate\Support\Facades\Auth;

use App\DomainValueObjects\UUIDGenerator\UUID;
use App\DomainValueObjects\Log\ClockOut\ClockOut;
use App\DomainValueObjects\Log\TimeStamp\TimeStamp;

use App\Http\Controllers\Api\Log\ClockOutDomain\Contracts\ClockOutContract;
use App\DomainValueObjects\Location\Location;
use App\TimeSheets;
use App\Logs;

class ClockOutService implements ClockOutContract
{
    private $domainName = "clockOut";

    public function clockOut($request)
    {
        $location = (string)$request['location'];
        
        $timeStamp = (string)$request['timeStamp'];

        $logUuid = $request['logUuid'];

        $user = Auth::user();

        $log = Logs::where('id', $logUuid)->first();

        if ($log->clock_out != null) {
            return ['message_error' => 'User has already clocked out.'];
        }
        
        $userInfo = $this->getUserLocationAndUserTimeSheetId($user, $location);
        
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

    private function getUserLocationAndUserTimeSheetId($user,$location):array
    {
        $userProfile = unserialize($user->user_profile);
        
        $userLocation = $userProfile->getProfileLocation();
        
        $this->validateLocation($userLocation,$location);
        
        $timeSheet = TimeSheets::where('user_id', 1)->first();
        
        return ['location' => $userLocation, 'timeSheet_id' => $timeSheet->id];
    }

    private function validateLocation(Location $userLocation, string $location){
        return true;
    }
}

 