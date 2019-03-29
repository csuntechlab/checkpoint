<?php

use Faker\Generator as Faker;

// Models
use App\Models\TimeSheets;
use App\Models\Organization;


use App\DomainValueObjects\UUIDGenerator\UUID;

$factory->define(TimeSheets::class, function (Faker $faker) {

    $orgId = Organization::first();
    $uuid = new UUID('timeSheets');
    $startDate = '2019-02-01 06:30:44';
    $endDate = '2019-02-01 06:30:44';

    return [
        'id' => $uuid->toString,
        'user_id' => 1,
        'organization_id' => $orgId,
        'start_date' => $startDate,
        'end_date' => $endDate
    ];
});
