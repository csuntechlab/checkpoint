<?php 
declare (strict_types = 1);
namespace App\DomainValueObjects\Log\TimeStamp;

use App\DomainValueObjects\UUIDGenerator\UUID;
use App\DomainValueObjects\Location\Location;


//Exceptions



class TimeStamp
{
    private $timeStamp =  null;

    public function __construct(UUID $uuid, string $timeStamp)
    {

        $this->uuid = $uuid;
        $this->timeStamp = $timeStamp;
        $this->validation();
    }

    private function validation()
    { }
}
