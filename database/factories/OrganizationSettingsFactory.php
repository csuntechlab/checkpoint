<?php

use Faker\Generator as Faker;

// Models
use App\Models\OrganizationSettings;
use App\DomainValueObjects\UUIDGenerator\UUID;

$factory->define(OrganizationSettings::class, function (Faker $faker) {
    $id = UUID::generate();
    return [
        'id' => $id,

    ];
});
