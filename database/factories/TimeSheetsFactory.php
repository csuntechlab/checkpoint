<?php

use App\TimeSheets;
use Faker\Generator as Faker;


use App\DomainValueObjects\UUIDGenerator\UUID;
use App\DomainValueObjects\TimeFrame\TimeFrame;

$factory->define(TimeSheets::class, function (Faker $faker) {
    $uuid = new UUID('timeSheets');
    $timeFrame = new TimeFrame(new UUID('timeFrame'), '01-01-2019', '01-30-2019');
    $timeFrame = serialize($timeFrame);
    return [
        'id' => $uuid->toString,
        'user_id' => 1,
        'time_frame' => $timeFrame
    ];
});
