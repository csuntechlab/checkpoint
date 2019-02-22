<?php
declare (strict_types = 1);
namespace DomainValueObjects\UserProfile;

use App\Http\Controllers\Api\Auth\UserProfileDomain\ProgramDomain\ProgramCode\ProgramCode;

//Exceptions
//User Profile
use App\Exceptions\UserProfileExceptions\UserIdNotDefined;
//Program Exceptions
use App\Exceptions\ProgramExceptions\ProgramNotDefined;
use App\Exceptions\ProgramExceptions\ProgramCodeNotDefined;
use App\Exceptions\ProgramExceptions\ProgramLocationNotDefined;

class UserProfile
{
    private $userId = null; // UUID
    private $programCode = null; // Program
    private $programLocation = null; // Location
    private $currentTimeFrame = null; // Time Frame

    private $studentLocation = null; // Location

    public function __construct(string $userId = null, ProgramCode $programCode = null)
    {
        $this->userId = $userId;
        $this->programCode = $programCode;
        $this->validate();
    }

    private function validate()
    {
        if ($this->userId == null || $this->userId == '') throw new UserIdNotDefined();
        //TODO: Get Program Object From db 
        if ($this->programCode == null) {
            throw new ProgramCodeNotDefined();
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
