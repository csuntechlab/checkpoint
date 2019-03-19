<?php
declare (strict_types = 1);
namespace App\DomainValueObjects\Location;

use App\Exceptions\LocationExceptions\InvalidGeoLocation;


class GeoLocation
{
    private $longitude;
    private $latitude;

    public function __construct(
        float $longitude = null,
        float $latitude = null
    ) {
        $this->longitude = $longitude;
        $this->latitude = $latitude;
        $this->validate();
    }

    private function validate()
    {
        if ($this->longitude == null || $this->latitude == null){
          throw new InvalidGeoLocation();
        }
    }
}
