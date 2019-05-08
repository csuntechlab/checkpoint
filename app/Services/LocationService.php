<?php

namespace App\Services;

// Domain Value Objects
use App\DomainValueObjects\Location\Address;

// Models
use App\Models\Project;
use App\Models\Location;

// Contracts
use App\Contracts\LocationContract;

class LocationService implements LocationContract
{
    public function updateOrganizationLocation(
        Address $address,
        $longitude,
        $latitude,
        $radius,
        $organizationId
    ) {
        try {
            $location = Location::create([
                'id' => $organizationId,
                'address' => $address->__toString(),
                'lat' => $latitude,
                'lng' => $longitude,
                'radius' => $radius
            ]);
        } catch (\Exception $e) {
            throw new UpdateOrganizationLocationFailed();
        }

        return $location;
    }

    public function updateProjectLocation(
        Address $address,
        $longitude,
        $latitude,
        $radius,
        Project $project
    ) {
        try {
            $location = Location::create([
                'id' => $project->id,
                'address' => $address->__toString(),
                'lat' => $latitude,
                'lng' => $longitude,
                'radius' => $radius
            ]);
        } catch (\Exception $e) {
            throw new UpdateProjectLocationFailed();
        }

        return $location;
    }
}
