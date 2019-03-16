<?php

declare (strict_types = 1);
namespace App\DomainValueObjects\TimeLog\TimeStamp;

use App\DomainValueObjects\UUIDGenerator\UUID;
use App\DomainValueObjects\Location\Location;
use App\Exceptions\TimeLogExceptions\TimeStamp\GenerateTimeStampFailed;


class TimeStamp
{
    private $timeStamp = null;
    private $uuid = null;

    public function __construct(UUID $uuid = null, string $timeStamp = null)
    {

        $this->uuid = $uuid;
        $this->timeStamp = $timeStamp;
        $this->validation();
    }

    private function validation()
    {
        if ($this->timeStamp == null || $this->timeStamp == '') throw new GenerateTimeStampFailed();

        if ($this->uuid == null) throw new GenerateTimeStampFailed();
    }
}
