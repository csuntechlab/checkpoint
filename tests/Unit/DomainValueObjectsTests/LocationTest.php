<?php

namespace Tests\Unit\DomainValueObjectsTests;

use Tests\TestCase;
use \App\DomainValueObjects\Location\Location;
use \App\DomainValueObjects\Location\Address;
use \App\DomainValueObjects\Location\GeoLocation;
use \App\DomainValueObjects\UUIDGenerator\UUID;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LocationTest extends TestCase
{

    public function test_a_location_with_address_is_successfully_created()
    {
        //parameters for objects
        $address_number = "9423 #A";
        $street = "Reseda Blvd";
        $city = "Northridge";
        $state = "California";
        $zip = "91324";

        $longitude = -118.536052;
        $latitude = 34.197676;

        //object parameters
        $UUID = new UUID('domainName');

        $address = new Address(
          $address_number,
          $street,
          $city,
          $state,
          $zip
        );

        $geoLocation = new GeoLocation($longitude, $latitude);

        $locationObject = Location::withAddress($UUID, $geoLocation, $address);
        $this->assertInstanceOf(Location::class, $locationObject);
    }

    public function test_invalid_UUID_throws_exception()
    {
      $this->expectException('App\Exceptions\UUIDExceptions\GenerateUUID5Failed');
      $exception = new Location();
    }

    public function test_invalid_geoLocation_throws_exception()
    {
      $UUID = new UUID('domainName');
      $this->expectException('App\Exceptions\LocationExceptions\GeoLocationNotDefined');
      $exception = new Location($UUID);
    }

    public function test_location_without_address_is_successfully_created()
    {
        //parameters for objects
        $address_number = "9423 #A";
        $street = "Reseda Blvd";
        $city = "Northridge";
        $state = "California";
        $zip = "91324";

        $longitude = -118.536052;
        $latitude = 34.197676;

        //object parameters
        $UUID = new UUID('domainName');

        $geoLocation = new GeoLocation($longitude, $latitude);

        $locationObject = new Location($UUID, $geoLocation);

        $this->assertInstanceOf(Location::class, $locationObject);
    }

    public function test_location_with_invalid_address_throws_exception()
    {
      $longitude = -118.536052;
      $latitude = 34.197676;

      //object parameters
      $UUID = new UUID('domainName');

      $geoLocation = new GeoLocation($longitude, $latitude);

      $this->expectException('App\Exceptions\LocationExceptions\AddressNotDefined');
      $locationObject = Location::withAddress($UUID, $geoLocation);
    }
}
