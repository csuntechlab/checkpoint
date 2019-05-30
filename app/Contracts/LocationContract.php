<?php
namespace App\Contracts;

use App\DomainValueObjects\Location\Address;

use App\Models\Program;

interface LocationContract
{
    public function update(Address $address, $longitude, $latitude, $radius, $organizationId);
}
