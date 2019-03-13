<?php

use App\Organization;
use Faker\Generator as Faker;


use App\DomainValueObjects\UUIDGenerator\UUID;
use App\DomainValueObjects\Location\Location;
use App\DomainValueObjects\TimeFrame\TimeFrame;
use App\DomainValueObjects\Location\GeoLocation;
use App\DomainValueObjects\Location\Address;

$factory->define(Organization::class, function (Faker $faker) {
    $organizationName = 'MetaLab';
    $uuid = new UUID('organization');
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
    $logoLocation = "./location_of_logo";
    return [
        'id' => $uuid->toString,
        'organization_name' => $organizationName,
        'address' => $address,
        'logo' => $logoLocation
    ];
});
