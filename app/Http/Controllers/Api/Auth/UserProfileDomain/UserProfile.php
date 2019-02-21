<?php
declare (strict_types = 1);
namespace App\Http\Controllers\Api\Auth\UserProfileDomain;

//Exceptions
// List
//User Profile

use App\Exceptions\UserProfileExceptions\UserIdNotDefined;

//Program Exceptions
use App\Exceptions\ProgramExceptions\ProgramNotDefined;
use App\Exceptions\ProgramExceptions\ProgramLocationNotDefined;


class UserProfile
{
    private $userId = null; // UUID
    private $programId = null; // Program
    private $programLocation = null; // Location
    private $currentTimeFrame = null; // Time Frame

    private $studentLocation = null; // Location

    public function __construct(string $userId = null, ProgramId $programId = null)
    {
        $this->userId = $userId;
        $this->programId = $programId;
        $this->validate();
    }

    private function validate()
    {
        if ($this->userId == null || $this->userId == '') throw new UserIdNotDefined();
        //TODO: Get Program Object From db 
        if ($this->programId == null) {
            throw new ProgramIdNotDefined();
        } else {
            $program = null;
            $this->programLocation = $this->validateProgramLocation($program);
            $this->currentTimeFrame = $this->validateProgramTimeFrame($program);
        }
    }

    private function validateProgramLocation($program)
    {
        $programLocation = $program->getProgramLocation();
        if ($programLocation == null) throw new ProgramLocationNotDefined();
        return $programLocation;
    }

    private function validateProgramTimeFrame($program)
    {
        $currentTimeFrame = $program->getCurrentTimeFrame();
        if ($currentTimeFrame == null) throw new ProgramTimeFrameNotDefined();
        return $currentTimeFrame;
    }

    public function getProfileLocation()
    { }
}
