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

class ClockInService implements ClockInContract
{
    private $domainName = "ClockIn";

    public function clockIn($request)
    {
        
        $location = (string)$request['location'];
        $timeStamp = (string)$request['timeStamp'];
        
        $uuid = new UUID($this->domainName);
        
        $userInfo = $this->getUserLocationAndUserTimeSheetId($location);
        
        $timeStamp = new TimeStamp(new UUID('timeStamp'), $timeStamp);

        $clockIn = new ClockIn($uuid, $timeStamp, $userInfo['location']);
        
    }

    private function getUserLocationAndUserTimeSheetId($location):array
    {
        $user = Auth::user();
        $userProfile = unserialize($user->user_profile);
        $userLocation = $userProfile->getProfileLocation();
        $this->validateLocation($userLocation,$location);
        $timeSheetId = 1;
        return ['location' => $userLocation, 'timeSheet_id' => $timeSheetId];
    }

    private function validateLocation(Location $userLocation, string $location){
        return true;
    }
}

 