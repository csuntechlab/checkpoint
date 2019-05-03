<?php

namespace App\Services;

// Domain Value Objects
use App\DomainValueObjects\Location\Address;

// Models
use App\User;
use App\Models\Location;
use App\Models\Organization;


// Auth
use Illuminate\Support\Facades\Auth;

// Contracts
use App\Contracts\LocationContract;

class LocationService implements LocationContract
{
    public function updateOrganizationLocation(
        Address $address,
        $longitude,
        $latitude,
        $radius
    ) {
        try {
            $user = Auth::User();

            $location = Location::create([
                'id' => $user->organization_id,
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
        $id
    ) {
        try {
            $user = Auth::User();

            $location = Location::create([
                'id' => $id,
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
