<?php 
declare (strict_types = 1);
namespace App\Http\Controllers\Api\TimeLog\TimePuncher\Services;

use function Opis\Closure\unserialize;

// TB Models
use App\TimeSheets;

// Domain Value Objects
use App\DomainValueObjects\Location\Location;

// Contracts
use App\Http\Controllers\Api\TimeLog\TimePuncher\Contracts\TimePuncherContract;
use App\DomainValueObjects\UUIDGenerator\UUID;

class TimePuncherService implements TimePuncherContract
{
    //TODO: Create unit test hard coded for now
    private function getTimeSheet($user){
        $timeSheet = TimeSheets::where('user_id', 1)->first();
        return $timeSheet;
    }

    private function getUserProfile($user) {
        $userProfile = unserialize($user->user_profile);
        return $userProfile;
    }

    //TODO create validation
    private function validateLocation(Location $userLocation, string $currentLocation){
   
         return true;
    }
  
    private function verifyUserLocation($user,$currentLocation){
        $userProfile = $this->getUserProfile($user);

        //Try catach

        $userLocation = $userProfile->getProfileLocation();

        $this->validateLocation($userLocation,$currentLocation);

        return $userLocation;
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

 