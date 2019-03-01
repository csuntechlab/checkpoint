<?php
declare (strict_types = 1);
namespace App\DomainValueObjects\Location;

use App\DomainValueObjects\UUIDGenerator\UUID;
use App\DomainValueObjects\Location\GeoLocation;
use App\DomainValueObjects\Location\Address;

use App\Exceptions\UUIDExceptions\GenerateUUID5Failed;
use App\Exceptions\LocationExceptions\LocationNotDefined;
use App\Exceptions\LocationExceptions\GeoLocationNotDefined;
use App\Exceptions\LocationExceptions\AddressNotDefined;

class Location
{
    private $uuid = null;
    private $geoLocation = null;
    private $address = null;

    public function __construct(
        UUID $uuid = null,
        GeoLocation $geoLocation = null,
        Address $address = null
    ) {
        $this->uuid = $uuid;
        $this->location = $geoLocation;
        $this->address = $address;
        $this->validate();
    }

    private function validate()
    {
        if ($this->uuid == null || $this->uuid == '') throw new GenerateUUID5Failed();
        if ($this->location == null) throw new GeoLocationNotDefined();
        if ($this->address == null) throw new AddressNotDefined();
    }
}
