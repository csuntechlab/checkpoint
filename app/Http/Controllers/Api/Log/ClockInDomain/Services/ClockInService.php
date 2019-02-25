<?php 
declare (strict_types = 1);
namespace App\Http\Controllers\Api\Log\ClockInDomain\Services;

use function Opis\Closure\serialize;
use function Opis\Closure\unserialize;

use Illuminate\Support\Facades\Auth;

use App\DomainValueObjects\UUIDGenerator\UUID;
use App\DomainValueObjects\Log\ClockIn\ClockIn;
use App\DomainValueObjects\Log\TimeStamp\TimeStamp;

use App\Http\Controllers\Api\Log\ClockInDomain\Contracts\ClockInContract;
use App\DomainValueObjects\Location\Location;
use App\TimeSheets;
use App\Logs;

class ClockInService implements ClockInContract
{
    private $domainName = "ClockIn";

    public function clockIn($request)
    {
        $location = (string)$request['location'];
        
        $timeStamp = (string)$request['timeStamp'];

        $user = Auth::user();
        
        $userInfo = $this->getUserLocationAndUserTimeSheetId($user, $location);
        
        $timeStamp = new TimeStamp(new UUID('timeStamp'), $timeStamp);

        $uuid = new UUID($this->domainName);
        
        $clockIn = new ClockIn($uuid, $timeStamp, $userInfo['location']);

        try {
            $user = Logs::create([
                'id' => $uuid->toString,
                'user_id' => $user->id,
                'clock_in' => serialize($clockIn),
            ]);
        } catch (Illuminate\Database\QueryException $e) {
            return ['message_error' => 'Clock In was not successfully created.'];
        }
        
        return ["message_success" => "Clock in was successfull", "clock_in_uuid" => $uuid->toString];
        
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

 