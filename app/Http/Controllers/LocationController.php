<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\DomainValueObjects\Location\Address;

use App\Http\Requests\LocationRequest;

use App\Http\Controllers\Controller;
use App\Services\LocationService;
use App\Contracts\LocationContract;

class LocationController extends Controller
{
    protected $locationUtility;

    public function __construct(LocationContract $locationContract)
    {
        $this->locationUtility = $locationContract;
    }

    public function update(LocationRequest $request, $id = null)
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
            return $this->locationUtility->updateOrganizationLocation($address, $longitude, $latitude, $radius);
        }else{
            return $this->locationUtility->updateProjectLoaction($address, $longitude, $latitude, $radius, $id);
        }

    }
}
