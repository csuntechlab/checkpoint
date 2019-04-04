<?php

use Faker\Generator as Faker;
use function Opis\Closure\serialize;

// Models
use App\Models\Organization;

// Domain Value Objects
use App\DomainValueObjects\UUIDGenerator\UUID;
use App\DomainValueObjects\Location\Address;


/**
 * $organizationName = $faker->company;
 * cityPrefix                          // 'Lake'
 * secondaryAddress                    // 'Suite 961'
 * state                               // 'NewMexico'
 * stateAbbr                           // 'OH'
 * citySuffix                          // 'borough'
 * streetSuffix                        // 'Keys'
 * buildingNumber                      // '484'
 * city                                // 'West Judge'
 * streetName                          // 'Keegan Trail'
 * streetAddress                       // '439 Karley Loaf Suite 897'
 * postcode                            // '17916'
 * address                             // '8888 Cummings Vista Apt. 101, Susanbury, NY 95473'
 * country                             // 'Falkland Islands (Malvinas)'
 * latitude($min = -90, $max = 90)     // 77.147489
 * longitude($min = -180, $max = 180)  // 86.211205
 */


$factory->define(Organization::class, function (Faker $faker) {
    $organizationName = $faker->company;
    $streetNumber = (string)$faker->biasedNumberBetween($min = 0, $max = 9999);
    $streetName = $faker->streetName;
    $city = $faker->city;
    $state = $faker->state;
    $postCode = $faker->postcode;
    $logoLocation = "/data/" . $faker->name . ".jpeg";

    $address = new Address($streetNumber, $streetName, $city, $state, $postCode);
    $id = UUID::generate();
    return [
        'id' => $id,
        'organization_name' => $organizationName,
        'address' => $address->__toString(),
        'logo' => $logoLocation
    ];
});
