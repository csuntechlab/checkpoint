<?php

use App\Organization;
use Faker\Generator as Faker;


use App\DomainValueObjects\UUIDGenerator\UUID;
use App\DomainValueObjects\Organization\OrganizationCode\OrganizationCode;
use App\DomainValueObjects\Organization\OrganizationProfile;
use App\DomainValueObjects\Location\Location;
use App\DomainValueObjects\TimeFrame\TimeFrame;

$factory->define(Organization::class, function (Faker $faker) {
    $uuid = new UUID('organization');
    $organizationCode = new OrganizationCode(new UUID('organizationCode'), 'MetaLab');
    $location = new Location(new UUID('organizationCode'), 'MetaLab');
    $timeFrame = new TimeFrame(new UUID('timeFrame'), '01-01-2019', '01-30-2019');
    $organizationProfile = new OrganizationProfile($uuid, $organizationCode, $location, $timeFrame);
    return [
        'uuid' => $uuid,
        'organization_code' => $organizationCode,
        'organization_profile' => $organizationProfile
    ];
});
