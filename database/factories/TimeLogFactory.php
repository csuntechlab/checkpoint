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
use function GuzzleHttp\json_encode;
use Carbon\Carbon;

$timeZone = 'America/Los_Angeles';

/**
 * Redo Time Log factory
 */

$factory->define(TimeLog::class, function (Faker $faker) {
    $user = User::where('id', 1)->first();
    $orgId = $user->organization_id;

    $timeSheet = TimeSheet::where('organization_id', $orgId)->first();

    $date =  "2019-02-01";
    $time = "06:30:44";
    $clockIn = new TimeStamp($date, $time);

    $carbonClockIn = $clockIn->carbon;

    $date =  "2019-02-01";
    $time = "09:30:44";
    $clockOut = new TimeStamp($date, $time);

    $carbonClockOut = $clockOut->carbon;

    $hours = $carbonClockIn->diffInRealHours($carbonClockOut);

    return [
        'id' => UUID::generate(),
        'user_id' => $user->id,
        'time_sheet_id' => $timeSheet->id,
        'organization_id' => $orgId,
        'date' => $date,
        'clock_in' =>  json_encode($clockIn->toArray()),
        'clock_out' => json_encode($clockOut->toArray()),
        'total_hours' => $hours,
    ];
});
