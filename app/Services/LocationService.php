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
    public function update(
        Address $address,
        $longitude,
        $latitude,
        $radius,
        $id
    ) {
        try {
            $location = Location::create([
                'id' => $id,
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
}
