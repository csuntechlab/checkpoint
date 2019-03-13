<?php

use App\Organization;
use App\TimeSheets;
use Faker\Generator as Faker;


use App\DomainValueObjects\UUIDGenerator\UUID;

$factory->define(TimeSheets::class, function (Faker $faker) {
    $organizationId = Organization::first();
    $uuid = new UUID('timeSheets');
    $startDate = '2019-02-01 06:30:44';
    $endDate = '2019-02-01 06:30:44';



    return [
        'id' => $uuid->toString,
        'user_id' => 1,
        'organization_id' => $organizationId,
        'start_date' => $startDate,
        'end_date' => $endDate
    ];
});
