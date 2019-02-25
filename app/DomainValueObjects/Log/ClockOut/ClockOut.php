<?php 
declare (strict_types = 1);
namespace App\DomainValueObjects\Log\ClockOut;

use App\DomainValueObjects\UUIDGenerator\UUID;
use App\DomainValueObjects\Log\TimeStamp\TimeStamp;
use App\DomainValueObjects\Location\Location;

use App\DomainValueObjects\Log\Clock;


//Exceptions



class ClockOut extends Clock
{

    public function __construct(UUID $uuid, TimeStamp $timeStamp, Location $location)
    {
        parent::__construct($uuid, $timeStamp, $location);
    }
}
