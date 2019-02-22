<?php

use App\Organization;
use Faker\Generator as Faker;


use App\DomainValueObjects\UUIDGenerator\UUID;

$factory->define(Organization::class, function (Faker $faker) {
    $uuid = new UUID('organization');
    return [];
});
