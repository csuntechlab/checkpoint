<?php
declare (strict_types = 1);
namespace App\DomainValueObjects\Organization;

//Objects used

use App\DomainValueObjects\UUIDGenerator\UUID;
use App\DomainValueObjects\Organization\OrganizationCode\OrganizationCode;
use App\DomainValueObjects\Location\Location;
use App\DomainValueObjects\TimeFrame\TimeFrame;

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
    private $organizationCode;
    private $organizationLocation = null;
    private $currentTimeFrame;

    public function __construct(
        UUID $uuid = null,
        OrganizationCode $organizationCode = null,
        Location $organizationLocation = null,
        TimeFrame $currentTimeFrame = null
    ) {
        $this->uuid = $uuid;
        $this->organizationCode = $organizationCode;
        $this->organizationLocation = $organizationLocation;
        $this->currentTimeFrame = $currentTimeFrame;
        $this->validate();
    }

    private function validate()
    {
        if ($this->uuid == null || $this->uuid == '') throw new GenerateUUID5Failed();
        if ($this->organizationCode == null || $this->organizationCode == '') throw new OrganizationNameNotDefined();
        if ($this->organizationLocation == null) throw new OrganizationLocationNotDefined();
        if ($this->currentTimeFrame == null) throw new OrganizationTimeFrameNotDefined();
    }

    public function getOrganizationCode()
    {
        //TODO: Add a try catch validation
        return $this->organizationCode;
    }

    public function getOrganizationLocation()
    {
        //TODO: Add a try catch validation
        return $this->organizationLocation;
    }

    public function getCurrentTimeFrame()
    {
        //TODO: Add a try catch validation
        return $this->currentTimeFrame;
    }
}
