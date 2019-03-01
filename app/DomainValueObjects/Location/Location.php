<?php
declare (strict_types = 1);
namespace App\DomainValueObjects\Location;

use App\DomainValueObjects\UUIDGenerator\UUID;
use App\DomainValueObjects\Location\GeoLocation;
use App\DomainValueObjects\Location\Address;

//Exceptions
//UUID
use App\Exceptions\UUIDExceptions\GenerateUUID5Failed;
use App\Exceptions\LocationExceptions\LocationNotDefined;



class Location
{
    private $uuid = null;
    private $location = null;
    private $address = null;

    public function __construct(
        UUID $uuid = null,
        $location = null,
        $address = null
    ) {
        $this->uuid = $uuid;
        $this->location = $location;
        $this->address = $address;

        $this->validate();
    }

    private function validate()
    {
        if ($this->uuid == null || $this->uuid == '') throw new GenerateUUID5Failed();
        if ($this->location == null) throw new LocationNotDefined();
        if ($this->address == null) throw new AddressNotDefined();
    }
}
