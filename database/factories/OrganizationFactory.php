<?php

use App\Models\Organization;
use Faker\Generator as Faker;


use App\DomainValueObjects\UUIDGenerator\UUID;
use App\DomainValueObjects\Location\Location;
use App\DomainValueObjects\Location\GeoLocation;
use App\DomainValueObjects\Location\Address;

use function Opis\Closure\serialize;

$factory->define(Organization::class, function (Faker $faker) {
    $organizationName = 'MetaLab';
    $uuid = new UUID('location');
    $address = Location::withAddress(
        $uuid,
        new GeoLocation(-118.536052, 34.197676),
        new Address(
            "9423 #A",
            "Reseda Blvd",
            "Northridge",
            "California",
            "91324"
        )
    );
    $id = new UUID('organization');
    $logoLocation = "./location_of_logo";
    $id = $id->toString;
    return [
        'id' => $id,
        'organization_name' => $organizationName,
        'address' => serialize($address),
        'logo' => $logoLocation
    ];
});
