<?php
declare (strict_types = 1);
namespace App\Http\Controllers\Api\Auth\UserProfileDomain\ProgramDomain;

use App\Http\Controllers\Api\UUIDGenerator\UUID;

//Exceptions
//UUID
use App\Exceptions\UUIDExceptions\GenerateUUID5Failed;

//Program Exceptions
use App\Exceptions\ProgramExceptions\ProgramNotDefined;
use App\Exceptions\ProgramExceptions\ProgramNameNotDefined;
use App\Exceptions\ProgramExceptions\ProgramLocationNotDefined;
use App\Exceptions\ProgramExceptions\ProgramTimeFrameNotDefined;

class Program
{
    private $uuid;
    private $programId;
    private $programLocation = null;
    private $currentTimeFrame;

    public function __construct(
        UUID $uuid = null,
        ProgramId $programId = null,
        Location $programLocation = null,
        TimeFrame $time_frame = null
    ) {
        $this->uuid = $uuid->toString;
        $this->programId = $programId;
        $this->programLocation = $programLocation;
        $this->currentTimeFrame = $time_frame;
        $this->validate();
    }

    private function validate()
    {
        if ($this->uuid == null || $this->uuid == '') throw new GenerateUUID5Failed();
        if ($this->programId == null || $this->programId == '') throw new ProgramNameNotDefined();
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
