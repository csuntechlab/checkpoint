<?php 
declare (strict_types = 1);
namespace App\DomainValueObjects\Log;

use App\DomainValueObjects\UUIDGenerator\UUID;
use App\DomainValueObjects\Log\TimeStamp\TimeStamp;
use App\DomainValueObjects\Location\Location;


//Exceptions



class ClockIn
{
    private $timeStamp =  null;
    private $location = null;

    public function __construct(UUID $uuid, TimeStamp $timeStamp, Location $location)
    {
        $this->uuid = $uuid;
        $this->timeStamp = $timeStamp;
        $this->location = $location;
        $this->validation();
    }

    private function validation()
    { }
}
