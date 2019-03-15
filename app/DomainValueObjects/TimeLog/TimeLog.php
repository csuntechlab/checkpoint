<?php 
declare (strict_types = 1);
namespace App\DomainValueObjects\TimeLog;

use App\DomainValueObjects\UUIDGenerator\UUID;
use App\DomainValueObjects\TimeLog\ClockIn\ClockIn;
use App\DomainValueObjects\TimeLog\ClockOut\ClockOut;

//Exceptions

class TimeLog
{
    private $uuid =  null;
    private $clockIn =  null;
    private $clockOut = null;

    public function __construct(UUID $uuid, ClockIn $clockIn, ClockOut $clockOut)
    {
        $this->uuid = $uuid;
        $this->clockIn = $clockIn;
        $this->clockOut = $clockOut;
        $this->validation();
    }

    private function validation()
    { }
}
