<?php
namespace App\Contracts;

use App\DomainValueObjects\Location\Address;

use App\Models\Project;

interface LocationContract
{
    public function updateOrganizationLocation(Address $address, $longitude, $latitude, $radius);
    public function updateProjectLocation(Address $address, $longitude, $latitude, $radius, Project $project);
}
