<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\DomainValueObjects\Location\Address.php;
use

use App\Http\Controllers\Controller;
use App\Contracts\LocationContract;

class LocationController extends Controller
{
    protected $locationUtility;

    public function __construct(LocationContract $locationContract)
    {
        $this->$locationUtility = $locationContract;
    }

    public function update(Request $request, $id = null)
    {
        $this->validate($type);

        $latitude = $request['latitude'];
        $longitude = $request['longitude'];

        $address = new Address(
          $request['address_number'],
          $request['street'],
          $request['city'],
          $request['state'],
          $request['zip']
        );

        return $this->locationUtility->updateLocation($address, $latitude, $longitude);
    }
}
