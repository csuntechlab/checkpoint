<?php

use Faker\Generator as Faker;

use App\Models\Program;
use App\Models\Organization;

use App\DomainValueObjects\UUIDGenerator\UUID;

$factory->define(Program::class, function (Faker $faker) {
    $uuid = new UUID('location');
    $id = $uuid->toString;
    $organizationId = Organization::first();
    $name = "backend";
    return [
        'id' => $id,
        'organization_id' => $organizationId,
        'program_name' => $name
    ];
});
