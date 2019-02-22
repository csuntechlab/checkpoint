<?php
declare (strict_types = 1);
namespace DomainValueObjects\UserProfile;

use App\DomainValueObjects\Organization\OrganizationCode;
//Exceptions
//User Profile
use App\Exceptions\UserProfileExceptions\UserIdNotDefined;
//Organization Exceptions
use App\Exceptions\OrganizationExceptions\OrganizationNotDefined;
use App\Exceptions\OrganizationExceptions\OrganizationCodeNotDefined;
use App\Exceptions\OrganizationExceptions\OrganizationLocationNotDefined;

class UserProfile
{
    private $userId = null; // UUID
    private $programCode = null; // Organization
    private $programLocation = null; // Location
    private $currentTimeFrame = null; // Time Frame

    private $studentLocation = null; // Location

    public function __construct(string $userId = null, OrganizationCode $programCode = null)
    {
        $this->userId = $userId;
        $this->programCode = $programCode;
        $this->validate();
    }

    private function validate()
    {
        if ($this->userId == null || $this->userId == '') throw new UserIdNotDefined();
        //TODO: Get Organization Object From db 
        if ($this->programCode == null) {
            throw new OrganizationCodeNotDefined();
        } else {
            $program = null;
            $this->programLocation = $this->validateOrganizationLocation($program);
            $this->currentTimeFrame = $this->validateOrganizationTimeFrame($program);
        }
    }

    private function validateOrganizationLocation($program)
    {
        $programLocation = $program->getOrganizationLocation();
        if ($programLocation == null) throw new OrganizationLocationNotDefined();
        return $programLocation;
    }

    private function validateOrganizationTimeFrame($program)
    {
        $currentTimeFrame = $program->getCurrentTimeFrame();
        if ($currentTimeFrame == null) throw new OrganizationTimeFrameNotDefined();
        return $currentTimeFrame;
    }

    public function getProfileLocation()
    { }
}
