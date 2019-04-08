<?php

// Models
use App\User;
use App\Models\TimeSheet;
use App\Models\TimeLog;
use App\Models\Organization;

// Domain Value Objects
use App\DomainValueObjects\UUIDGenerator\UUID;
use App\DomainValueObjects\TimeLog\ClockIn\ClockIn;
use App\DomainValueObjects\TimeLog\ClockOut\ClockOut;
use App\DomainValueObjects\TimeLog\TimeStamp\TimeStamp;

use Faker\Generator as Faker;

$timeZone = 'America/Los_Angeles';

/**
 * Redo Time Log factory
 */

$factory->define(TimeLog::class, function (Faker $faker) {

    $uuid = new UUID('log');
    $user = User::where('id', 1)->first();
    $orgId = Organization::first()->id;

    $timeSheet = TimeSheet::where('user_id', $user->id)->first();

    $date =  "2019-02-01";
    $time = "06:30:44";
    $timeStampClockIn = new TimeStamp(new UUID('timeStamp'), $date, $time);

    $date =  "2019-02-01";
    $time = "09:30:44";
    $timeStampClockOut = new TimeStamp(new UUID('timeStamp'), $date, $time);

    $clockIn = new ClockIn(new UUID('clockIn'), $timeStampClockIn);
    $clockOut = new ClockOut(new UUID('clockOut'), $timeStampClockOut);

    return [
        'id' => UUID::generate(),
        'user_id' => $user->id,
        'time_sheet_id' => $timeSheet->id,
        'organization_id' => $orgId,
        'date' => $date,
        'clock_in' =>  serialize($clockIn),
        'clock_out' => serialize($clockOut)
    ];
});
