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


    // Generate a random date with ranges
    // upper-limit -> today, lower-limit -> today-6months
    $tempDate = Carbon::now()->subMonths(rand(0,6))->subDays(rand(0,7))->subHours(rand(0, 12));

    $year = $tempDate->year;
    $month = $tempDate->month;
    $day = $tempDate->day;
    $hour = $tempDate->hour;
    $minute = $tempDate->minute;
    $second = $tempDate->second;
    
    // String concatination
    $date = $year.'-'.$month.'-'.$day;
    $time = $hour.':'.$minute.':'.$second;

    $clockIn = new TimeStamp($date, $time);

    $carbonClockIn = $clockIn->carbon;

    // Simulate a shift
    $tempDate = $tempDate->addHours(rand(1,8));

    $year = $tempDate->year;
    $month = $tempDate->month;
    $day = $tempDate->day;
    $hour = $tempDate->hour;
    $minute = $tempDate->minute;
    $second = $tempDate->second;
    
    //string concatination
    $date = $year.'-'.$month.'-'.$day;
    $time = $hour.':'.$minute.':'.$second;

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
