<?php

namespace App\Http\Controllers;

use App\DomainValueObjects\Location\Address;

use App\Http\Requests\LocationRequest;

use App\Http\Controllers\Controller;
use App\Contracts\LocationContract;

class LocationController extends Controller
{
    protected $locationUtility;

    public function __construct(LocationContract $locationContract)
    {
        $this->locationUtility = $locationContract;
    }

    public function add(LocationRequest $request, $id = null)
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

        if($id == null){
            return $this->locationUtility->addOrganizationLocation($address, $longitude, $latitude, $radius);
        }else{
            return $this->locationUtility->addProjectLocation($address, $longitude, $latitude, $radius, $id);
        }
    }
}
