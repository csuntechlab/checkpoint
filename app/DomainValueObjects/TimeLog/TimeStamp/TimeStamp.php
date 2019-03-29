<?php

declare (strict_types = 1);
namespace App\DomainValueObjects\TimeLog\TimeStamp;

use App\DomainValueObjects\UUIDGenerator\UUID;
use App\DomainValueObjects\Location\Location;
use App\Exceptions\TimeLogExceptions\TimeStamp\GenerateTimeStampFailed;


class TimeStamp
{
    private $uuid = null;
    private $date = null;
    private $time = null;

    public function __construct(UUID $uuid = null, string $date = null, string $time = null)
    {

        $this->uuid = $uuid;
        $this->date = $date;
        $this->time = $time;
        $this->validation();
    }

    private function validation()
    {
        $dateBool = $this->date == null || $this->date == '';

        $timeBool = $this->time == null || $this->time == '';

        $uuidBool = $this->uuid == null;

        if ($dateBool || $timeBool || $uuidBool) throw new GenerateTimeStampFailed();
    }

    public function getTimeStampString()
    {
        return $this->date . " " . $this->time;
    }
}
