<?php

use Faker\Generator as Faker;

use App\Models\Location;
use App\Models\Project;
use App\Models\Organization;

$factory->define(Location::class, function (Faker $faker) {
    $streetNumber = (string)$faker->biasedNumberBetween($min = 0, $max = 9999);
    $streetName = $faker->streetName;
    $city = $faker->city;
    $state = $faker->state;
    $postCode = $faker->postcode;
    $address = new Address($streetNumber, $streetName, $city, $state, $postCode);

    $lat = $faker->latitude($min = -90, $max = 90);
    $lng = $faker->longitude($min = -180, $max = 180);

    $randomNumber = rand(1, 2);

    $id = Organization::all()->random()->id;

    if ($randomNumber % 2 == 0) {
        $id = Project::all()->random()->id;
    }

    return [
        'id' => $id,
        'address' => $address->__toString(),
        'lat' => $lat,
        'lng' => $lng,
    ];
});
