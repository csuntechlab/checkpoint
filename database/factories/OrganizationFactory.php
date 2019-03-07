<?php

use App\Organization;
use Faker\Generator as Faker;


use App\DomainValueObjects\UUIDGenerator\UUID;
use App\DomainValueObjects\Organization\OrganizationCode\OrganizationCode;
use App\DomainValueObjects\Organization\OrganizationProfile;
use App\DomainValueObjects\Location\Location;
use App\DomainValueObjects\TimeFrame\TimeFrame;
use App\DomainValueObjects\Location\GeoLocation;
use App\DomainValueObjects\Location\Address;

$factory->define(Organization::class, function (Faker $faker) {
    $uuid = new UUID('organization');
    $organizationCode = new OrganizationCode(new UUID('organizationCode'), 'MetaLab');
    $location = new Location(
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
    $timeFrame = new TimeFrame(new UUID('timeFrame'), '01-01-2019', '01-30-2019');
    $organizationProfile = new OrganizationProfile($uuid, $organizationCode, $location, $timeFrame);
    $organizationProfile = serialize($organizationProfile);
    return [
        'id' => $uuid->toString,
        'organization_code' => $organizationCode->code,
        'organization_profile' => $organizationProfile
    ];
});
