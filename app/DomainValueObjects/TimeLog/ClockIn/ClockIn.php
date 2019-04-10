<?php
declare (strict_types = 1);
namespace App\DomainValueObjects\TimeLog\ClockIn;

use App\DomainValueObjects\UUIDGenerator\UUID;
use App\DomainValueObjects\TimeLog\TimeStamp\TimeStamp;

use App\DomainValueObjects\TimeLog\TimePuncher;


class ClockIn extends TimePuncher
{
    public function __construct(UUID $uuid, TimeStamp $timeStamp)
    {
        parent::__construct($uuid, $timeStamp);
    }

    public function toJsonString()
    {
        $data = $this->timeStamp->toArray();
        return $data;
    }
}
