<?php

namespace Tests\Unit\DomainValueObjectsTests;

use Tests\TestCase;
use \App\DomainValueObjects\Location\Address;

use \App\DomainValueObjects\UUIDGenerator\UUID;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddressTest extends TestCase
{

    public function test_a_address_is_successfully_created()
    {
        $address_number = "9423 #A";
        $street = "Reseda Blvd";
        $city = "Northridge";
        $state = "California";
        $zip = "91324";

        $address = new Address(
          $address_number,
          $street,
          $city,
          $state,
          $zip
        );

        $this->assertInstanceOf(Address::class, $address);
    }

    public function test_Invalid_address_throws_exception()
    {
        $this->expectException('App\Exceptions\LocationExceptions\InvalidAddress');
        $exception = new Address();
    }
}
