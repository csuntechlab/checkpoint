<?php

use Faker\Generator as Faker;
use App\DomainValueObjects\UUIDGenerator\UUID;


use App\Models\Project;
use App\Models\Organization;

$factory->define(Project::class, function (Faker $faker) {
    $name = $faker->unique()->name;
    return [
        'id' => UUID::generate(),
        'organization_id' => Organization::all()->random()->id,
        'name' => $name,
        'display_name' => $name,
    ];
});
