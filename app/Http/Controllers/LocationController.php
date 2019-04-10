<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use App\Contracts\LocationContract;

class LocationController extends Controller
{
    protected $locationUtility;

    public function __construct(LocationContract $locationContract)
    {
        $this->$locationUtility = $locationContract;
    }

    public function update(Request $request, $id, $type = null)
    {

        $latitude = $request['latitude'];
        $longitude = $request['longitude'];


        return $this->locationUtility->updateLocation();
    }
}
