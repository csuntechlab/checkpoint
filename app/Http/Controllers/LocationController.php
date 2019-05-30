<?php

namespace App\Http\Controllers;

// Auth
use Illuminate\Support\Facades\Auth;

// Controllers
use App\Http\Controllers\Controller;

// Domain Value Objects
use App\DomainValueObjects\Location\Address;

// Requests
use App\Http\Requests\LocationRequest;

// Contract
use App\Contracts\LocationContract;

// Models
use App\Models\Program;

class LocationController extends Controller
{
    protected $locationUtility;

    public function __construct(LocationContract $locationContract)
    {
        $this->locationUtility = $locationContract;
    }

    public function createLocation(LocationRequest $request, Program $program = null)
    {
        $user = Auth::user();
        $organizationId = $user->getOrganizationIdAuthorizeAdmin();
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

        if ($program == null) {
            return $this->locationUtility->createLocation($address, $longitude, $latitude, $radius, $organizationId);
        } else {
            // $user->authorizeProject($program);
            return $this->locationUtility->createLocation($address, $longitude, $latitude, $radius, $program->id);
        }
    }
}
