<?php

// Models
use App\User;
use App\Models\TimeSheets;
use App\Models\TimeLog;

// Domain Value Objects
use App\DomainValueObjects\UUIDGenerator\UUID;
use App\DomainValueObjects\TimeLog\ClockIn\ClockIn;
use App\DomainValueObjects\TimeLog\ClockOut\ClockOut;
use App\DomainValueObjects\TimeLog\TimeStamp\TimeStamp;

use Faker\Generator as Faker;

$factory->define(TimeLog::class, function (Faker $faker) {
    $uuid = new UUID('log');
    $user = User::where('id', 1)->first();

    $timeSheet = TimeSheets::where('user_id', $user->id)->first();

    $timeStamp =  "2019-02-01 06:30:44";
    $timeStampClockIn = new TimeStamp(new UUID('timeStamp'), $timeStamp);

    $timeStamp =  "2019-02-01 09:30:44";
    $timeStampClockOut = new TimeStamp(new UUID('timeStamp'), $timeStamp);

    $clockIn = new ClockIn(new UUID('clockIn'), $timeStampClockIn);
    $clockOut = new ClockOut(new UUID('clockOut'), $timeStampClockOut);

    return [
        'id' => $uuid->toString,
        'user_id' => $user->id,
        'time_sheet_id' => $timeSheet->id,
        'clock_in' =>  serialize($clockIn),
        'clock_out' => serialize($clockOut)
    ];
});
