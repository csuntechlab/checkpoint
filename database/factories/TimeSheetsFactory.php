<?php

use Faker\Generator as Faker;

// Models
use App\Models\TimeSheets;
use App\Models\Program;


use App\DomainValueObjects\UUIDGenerator\UUID;

$factory->define(TimeSheets::class, function (Faker $faker) {

    $programId = Program::first();
    $uuid = new UUID('timeSheets');
    $startDate = '2019-02-01 06:30:44';
    $endDate = '2019-02-01 06:30:44';

    return [
        'id' => $uuid->toString,
        'user_id' => 1,
        'program_id' => $programId,
        'start_date' => $startDate,
        'end_date' => $endDate
    ];
});
