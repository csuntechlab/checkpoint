<?php
declare (strict_types = 1);
namespace App\DomainValueObjects\Location;

use App\DomainValueObjects\UUIDGenerator\UUID;
use App\DomainValueObjects\Location\GeoLocation;
use App\DomainValueObjects\Location\Address;

use App\Exceptions\UUIDExceptions\GenerateUUID5Failed;
use App\Exceptions\LocationExceptions\LocationNotDefined;
use App\Exceptions\LocationExceptions\GeoLocationNotDefined;
use App\Exceptions\LocationExceptions\AddressNotDefined;

class Location
{
  private $uuid = null;
  private $geoLocation = null;
  private $address = null;

  public function __construct(
    string $uuid = null,
    GeoLocation $geoLocation = null
  ) {
    $this->uuid = $uuid;
    $this->geoLocation = $geoLocation;
    $this->validate();
  }

  public static function withAddress(
    string $uuid = null,
    GeoLocation $geoLocation = null,
    Address $address = null
  ) {
    $instance = new self($uuid, $geoLocation);
    $instance->setAddress($address);
    return $instance;
  }

  protected function setAddress($address)
  {
    $this->address = $address;
    $this->validateWithAddress();
  }

  private function validate()
  {
    if ($this->uuid == null || $this->uuid == '') throw new GenerateUUID5Failed();
    if ($this->geoLocation == null) throw new GeoLocationNotDefined();
  }

  private function validateWithAddress()
  {
    if ($this->address == null || ! ($this->address instanceof Address)) throw new AddressNotDefined();
  }
}
