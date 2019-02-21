<?php
declare (strict_types = 1);
namespace App\Http\Controllers\Api\Auth\UserProfileDomain\TimeFrameDomain;

use App\Http\Controllers\Api\UUIDGenerator\UUID;

//Exceptions
//UUID
use App\Exceptions\UUIDExceptions\GenerateUUID5Failed;



class TimeFrame
{
    private $uuid;
    private $programLocation = null;
    private $currentTimeFrame;

    public function __construct(
        UUID $uuid = null,
        string $startDate = null, //Create a Date Class
        string $endDate = null // Create a Date Class
    ) {
        $this->uuid = $uuid->toString;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->validate();
    }

    private function validate()
    {
        if ($this->uuid == null || $this->uuid == '') throw new GenerateUUID5Failed();
        if ($this->startDate == null || $this->startDate == '') throw new DateNotDefined();
        if ($this->endDate == null || $this->endDate == '') throw new DateNotDefined();
        if ($this->validate_time_period($this->startDate, $this->endDate)) throw new TimeFrameNotValid();
    }

    private function validateTimePeriod($startDate, $endDate)
    {
        //TODO: Create Validation to verify time period is apporiate
        return false;
    }
}
