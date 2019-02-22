<?php
declare (strict_types = 1);
namespace App\DomainValueObjects\UserProfile;

use App\DomainValueObjects\UUIDGenerator\UUID;
use App\DomainValueObjects\Organization\OrganizationCode\OrganizationCode;
//Exceptions
//User Profile
use App\Exceptions\UserProfileExceptions\UserIdNotDefined;
//Organization Exceptions
use App\Exceptions\OrganizationExceptions\OrganizationNotDefined;
use App\Exceptions\OrganizationExceptions\OrganizationCodeNotDefined;
use App\Exceptions\OrganizationExceptions\OrganizationLocationNotDefined;
use App\DomainValueObjects\Organization\OrganizationProfile;


class UserProfile
{
    private $userId = null; // UUID
    private $organizationCode = null; // Organization
    private $organizationLocation = null; // Location
    private $currentTimeFrame = null; // Time Frame

    private $studentLocation = null; // Location

    public function __construct(UUID $userId = null, OrganizationProfile $organizationProfile = null)
    {
        $this->userId = $userId;
        $this->validate($organizationProfile);
    }

    private function validate(OrganizationProfile $organizationProfile)
    {
        if ($this->userId == null || $this->userId == '') throw new UserIdNotDefined();
        if ($organizationProfile  == null) {
            throw new OrganizationNotDefined();
        } else {
            $this->organizationLocation = $this->validateOrganizationLocation($organizationProfile);
            $this->currentTimeFrame = $this->validateOrganizationTimeFrame($organizationProfile);
        }
    }

    private function validateOrganizationLocation(OrganizationProfile $organizationProfile)
    {
        $organizationLocation = $organizationProfile->getOrganizationLocation();
        if ($organizationLocation == null) throw new OrganizationLocationNotDefined();
        return $organizationLocation;
    }

    private function validateOrganizationTimeFrame(OrganizationProfile $organizationProfile)
    {
        $currentTimeFrame = $organizationProfile->getCurrentTimeFrame();
        if ($currentTimeFrame == null) throw new OrganizationTimeFrameNotDefined();
        return $currentTimeFrame;
    }

    public function getProfileLocation()
    {
        //add try catch validation
        return $this->organizationLocation;
    }
}
