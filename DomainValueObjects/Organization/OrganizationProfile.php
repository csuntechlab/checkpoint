<?php
declare (strict_types = 1);
namespace DomainValueObjects\Organization;

//Objects used

use App\Http\Controllers\Api\UUIDGenerator\UUID;
use App\Http\Controllers\UserProfileDomain\OrganizationDomain\OrganizationCode\OrganizationCode;
use App\Http\Controllers\UserProfileDomain\LocationDomain\Location;
use App\Http\Controllers\UserProfileDomain\TimeFrameDomain\TimeFrame;

//Exceptions
//UUID
use App\Exceptions\UUIDExceptions\GenerateUUID5Failed;

//Organization Exceptions
use App\Exceptions\OrganizationExceptions\OrganizationNotDefined;
use App\Exceptions\OrganizationExceptions\OrganizationNameNotDefined;
use App\Exceptions\OrganizationExceptions\OrganizationLocationNotDefined;
use App\Exceptions\OrganizationExceptions\OrganizationTimeFrameNotDefined;

class OrganizationProfile
{
    private $uuid;
    private $programCode;
    private $programLocation = null;
    private $currentTimeFrame;

    public function __construct(
        UUID $uuid = null,
        OrganizationCode $programCode = null,
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
        if ($this->programCode == null || $this->programCode == '') throw new OrganizationNameNotDefined();
        if ($this->programLocation == null) throw new OrganizationLocationNotDefined();
        if ($this->time_frame == null) throw new OrganizationTimeFrameNotDefined();
    }

    public function getOrganizationLocation()
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
