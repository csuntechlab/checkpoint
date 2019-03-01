<?php

namespace Tests\Unit\DomainValueObjectsTests;

use Tests\TestCase;
use \App\DomainValueObjects\Location\Location;
use \App\Exceptions\LocationExceptions\AddressNotDefined;
use \App\DomainValueObjects\UUIDGenerator\UUID;
use \App\Exceptions\UUIDExceptions\GenerateUUID5Failed;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LocationTest extends TestCase
{

    public function test_a_location_is_successfully_created()
    {
        $UUID = new UUID("domainName");

        $address = [
          'address_number' => '9423 #A',
          'street' => 'Reseda Blvd',
          'city' => 'Northridge',
          'state' => 'California',
          'zip' => 91324,
        ];

        $location = [
          'longitude' => -118.536052,
          'latitude' => 34.197676
        ];

        $locationObject = new Location($UUID, $address, $location);

        $this->assertInstanceOf(Location::class, $locationObject);
    }

    public function test_invalid_UUID_throws_exception()
    {
      $this->expectException('App\Exceptions\UUIDExceptions\GenerateUUID5Failed');
      $exception = new Location();
    }

    public function test_invalid_geoLocation_throws_exception()
    {
      $UUID = new UUID("domainName");
      $this->expectException('App\Exceptions\LocationExceptions\LocationNotDefined');
      $exception = new Location($UUID);
    }

    public function test_invalid_address_throws_exception()
    {
      $UUID = new UUID("domainName");
      $location = [
        'longitude' => -118.536052,
        'latitude' => 34.197676
      ];
      $this->expectException('App\Exceptions\LocationExceptions\AddressNotDefined');
      $exception = new Location($UUID, $location);
    }
}
