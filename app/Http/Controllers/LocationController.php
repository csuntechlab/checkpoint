<?php

namespace App\Http\Controllers;

use App\DomainValueObjects\Location\Address;

use App\Http\Requests\LocationRequest;

use App\Http\Controllers\Controller;
use App\Contracts\LocationContract;
use App\Models\Project;

class LocationController extends Controller
{
    protected $locationUtility;

    public function __construct(LocationContract $locationContract)
    {
        $this->locationUtility = $locationContract;
    }

    // We should type hint with Project 
    public function update(LocationRequest $request, Project $project = null)
    {
        $longitude = $request['longitude'];
        $latitude = $request['latitude'];
        $radius = $request['radius'];

        $address = new Address(
            $request['address_number'],
            $request['street'],
            $request['city'],
            $request['state'],
            $request['zip']
        );

        if ($project == null) {
            return $this->locationUtility->updateOrganizationLocation($address, $longitude, $latitude, $radius);
        } else {
            return $this->locationUtility->updateProjectLocation($address, $longitude, $latitude, $radius, $project);
        }
    }
}
