<?php

use Faker\Generator as Faker;
use App\DomainValueObjects\UUIDGenerator\UUID;

use App\Models\Category;
use App\Models\Organization;

$factory->define(Category::class, function (Faker $faker) {

    $jobTitle = $faker->unique()->jobTitle;
    return [
        'id' => UUID::generate(),
        'organization_id' => Organization::all()->random()->id,
        'name' => $jobTitle,
        'display_name' => $jobTitle,
    ];
});
