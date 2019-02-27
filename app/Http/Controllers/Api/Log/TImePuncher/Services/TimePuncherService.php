<?php 
declare (strict_types = 1);
namespace App\Http\Controllers\Api\Log\TimePuncher\Services;

use function Opis\Closure\unserialize;

use App\TimeSheets;
use App\DomainValueObjects\Location\Location;

use App\Http\Controllers\Api\Log\TimePuncher\Contracts\TimePuncherContract;

class TimePuncherService implements TimePuncherContract
{

    public function getUserLocationAndUserTimeSheetId($user,$currentLocation):array
    {
        $userProfile = unserialize($user->user_profile);
        
        $userLocation = $userProfile->getProfileLocation();
        
        $this->validateLocation($userLocation,$currentLocation);
        
        $timeSheet = TimeSheets::where('user_id', 1)->first();
        
        return ['location' => $userLocation, 'timeSheetId' => $timeSheet->id];
    }

    private function validateLocation(Location $userLocation, string $currentLocation){
        return true;
    }
}

 