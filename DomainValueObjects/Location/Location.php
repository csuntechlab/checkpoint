<?php
declare (strict_types = 1);
namespace DomainValueObjects\Location;

use DomainValueObjects\UUIDGenerator\UUID;

//Exceptions
//UUID
use App\Exceptions\UUIDExceptions\GenerateUUID5Failed;
use App\Exceptions\LocationExceptions\LocationNotDefined;



class Location
{
    private $uuid;
    private $location = null;

    public function __construct(
        UUID $uuid = null,
        string $location = null //investigate data type
    ) {
        $this->uuid = $uuid->toString;
        $this->location = $location;
        $this->validate();
    }

    private function validate()
    {
        if ($this->uuid == null || $this->uuid == '') throw new GenerateUUID5Failed();
        if ($this->location == null || $this->location == '') throw new LocationNotDefined();
    }
}
