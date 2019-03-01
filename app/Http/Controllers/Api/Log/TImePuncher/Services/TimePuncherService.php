<?php 
declare (strict_types = 1);
namespace App\Http\Controllers\Api\Log\TimePuncher\Services;

use function Opis\Closure\unserialize;

// TB Models
use App\TimeSheets;

// Domain Value Objects
use App\DomainValueObjects\Location\Location;

// Contracts
use App\Http\Controllers\Api\Log\TimePuncher\Contracts\TimePuncherContract;
use App\DomainValueObjects\UUIDGenerator\UUID;

class TimePuncherService implements TimePuncherContract
{
    private function getTimeSheet($user){
        $timeSheet = TimeSheets::where('user_id', 1)->first();
        return $timeSheet;
    }

    private function getUserProfile($user) {
        $userProfile = unserialize($user->user_profile);
        return $userProfile;
    }

    private function verifyUserLocation($user,$currentLocation){
        $userProfile = $this->getUserProfile($user);

        //Try catach
        $userLocation = $userProfile->getProfileLocation();

        $this->validateLocation($userLocation,$currentLocation);

        return $userLocation;
    }
    
    private function validateLocation(Location $userLocation, string $currentLocation){
        return true;
    }

    public function getUserLocation($user,$currentLocation){
        $userLocation = $this->verifyUserLocation($user,$currentLocation);
        return $userLocation;
    }

    public function getUserLocationAndUserTimeSheetId($user,$currentLocation):array
    {
        $userLocation = $this->verifyUserLocation($user,$currentLocation);
                
        $timeSheet = $this->getTimeSheet($user);
        
        return ['location' => $userLocation, 'timeSheetId' => $timeSheet->id];
    }
}

 