<?php
declare (strict_types = 1);
namespace DomainValueObjects\Program;

//Objects used

use App\Http\Controllers\Api\UUIDGenerator\UUID;
use App\Http\Controllers\UserProfileDomain\ProgramDomain\ProgramCode\ProgramCode;
use App\Http\Controllers\UserProfileDomain\LocationDomain\Location;
use App\Http\Controllers\UserProfileDomain\TimeFrameDomain\TimeFrame;

//Exceptions
//UUID
use App\Exceptions\UUIDExceptions\GenerateUUID5Failed;

//Program Exceptions
use App\Exceptions\ProgramExceptions\ProgramNotDefined;
use App\Exceptions\ProgramExceptions\ProgramNameNotDefined;
use App\Exceptions\ProgramExceptions\ProgramLocationNotDefined;
use App\Exceptions\ProgramExceptions\ProgramTimeFrameNotDefined;

class ProgramProfile
{
    private $uuid;
    private $programCode;
    private $programLocation = null;
    private $currentTimeFrame;

    public function __construct(
        UUID $uuid = null,
        ProgramCode $programCode = null,
        Location $programLocation = null,
        TimeFrame $time_frame = null
    ) {
        $this->uuid = $uuid->toString;
        $this->programCode = $programCode;
        $this->programLocation = $programLocation;
        $this->currentTimeFrame = $time_frame;
        $this->validate();
    }

    private function validate()
    {
        if ($this->uuid == null || $this->uuid == '') throw new GenerateUUID5Failed();
        if ($this->programCode == null || $this->programCode == '') throw new ProgramNameNotDefined();
        if ($this->programLocation == null) throw new ProgramLocationNotDefined();
        if ($this->time_frame == null) throw new ProgramTimeFrameNotDefined();
    }

    public function getProgramLocation()
    {
        //TODO: Add a try catch validation
        return $this->programLocation;
    }

    public function getCurrentTimeFrame()
    {
        //TODO: Add a try catch validation
        return $this->currentTimeFrame;
    }
}
