<?php 
declare (strict_types = 1);
namespace App\DomainValueObjects\TimeLog;

use App\DomainValueObjects\UUIDGenerator\UUID;
use App\DomainValueObjects\TimeLog\TimeStamp\TimeStamp;
use App\DomainValueObjects\Location\Location;


//Exceptions



class TimePuncher
{
    private $uuid = null;
    private $timeStamp =  null;
    private $location = null;

    public function __construct(UUID $uuid, TimeStamp $timeStamp)
    {
        $this->uuid = $uuid;
        $this->timeStamp = $timeStamp;
        $this->validation();
    }

    private function validation()
    { }

    public function getTimeStamp()
    {
        return $this->timeStamp;
    }
}
