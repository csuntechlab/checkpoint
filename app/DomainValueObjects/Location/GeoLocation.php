<?php
declare (strict_types = 1);
namespace App\DomainValueObjects\Location;

use App\Exceptions\LocationExceptions\InvalidGeoLocation;



class GeoLocation
{
    private $longitude = null;
    private $latitude = null;

    public function __construct(
        $longitude = null,
        $latitude = null
    ) {
        $this->longitude = $longitude;
        $this->latitude = $latitude;
        $this->validate();
    }

    private function validate()
    {
        if ($this->longitude == null || $this->latitude == null){
          throw new GeoLocationNotDefined();
        }
    }
}