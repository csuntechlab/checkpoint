<?php
namespace App\Contracts;

use App\DomainValueObjects\Location\Address;

interface LocationContract
{
    public function addOrganizationLocation(Address $address, $longitude, $latitude, $radius);
    public function addProjectLocation(Address $address, $longitude, $latitude, $radius, $id);
}
