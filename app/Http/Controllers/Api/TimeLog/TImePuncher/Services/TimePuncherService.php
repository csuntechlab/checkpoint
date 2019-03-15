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
        return $timeSheet->id;
    }

    public function getTimeSheetId($user)
    {           
        $timeSheetId = $this->getTimeSheet($user);
        
        return $timeSheetId;
    }
}

 