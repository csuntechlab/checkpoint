<?php
namespace App\Contracts;

use App\DomainValueObjects\Location\Address;

use App\Models\Project;

interface LocationContract
{
    public function createLocation(Address $address, $longitude, $latitude, $radius, $organizationId);
}
