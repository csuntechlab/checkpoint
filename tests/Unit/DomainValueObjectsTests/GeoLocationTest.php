<?php

namespace Tests\Unit\DomainValueObjectsTests;

use Tests\TestCase;
use \App\DomainValueObjects\Location\GeoLocation;

use \App\DomainValueObjects\UUIDGenerator\UUID;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GeoLocationTest extends TestCase
{

    public function test_geoLocation_is_successfully_created()
    {
        $longitude = -118.536052;
        $latitude = 34.197676;
        $geoLocation = new GeoLocation($longitude, $latitude);
        $this->assertInstanceOf(GeoLocation::class, $geoLocation);
    }

    public function test_Invalid_geoLocation_throws_exception()
    {
      $this->expectException('App\Exceptions\LocationExceptions\InvalidGeoLocation');
      $exception = new geoLocation();
    }
}
