<?php 
declare (strict_types = 1);
namespace App\DomainValueObjects\TimeLog\ClockOut;

use App\DomainValueObjects\UUIDGenerator\UUID;
use App\DomainValueObjects\TimeLog\TimeStamp\TimeStamp;
use App\DomainValueObjects\Location\Location;

use App\DomainValueObjects\TimeLog\TimePuncher;


//Exceptions



class ClockOut extends TimePuncher
{

    public function __construct(UUID $uuid, TimeStamp $timeStamp, Location $location)
    {
        parent::__construct($uuid, $timeStamp, $location);
    }
}
