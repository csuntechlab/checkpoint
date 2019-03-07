<?php

use Faker\Generator as Faker;
use App\User;
use App\TimeSheets;

use function Opis\Closure\serialize;

use App\DomainValueObjects\UUIDGenerator\UUID;
use App\DomainValueObjects\Log\TimeStamp\TimeStamp;
use App\DomainValueObjects\Log\ClockIn\ClockIn;
use App\DomainValueObjects\Log\ClockOut\ClockOut;


$factory->define(App\Logs::class, function (Faker $faker) {
    $uuid = new UUID('log');
    $user = User::where('id', 1)->first();

    $timeSheet = TimeSheets::where('user_id', $user->id)->first();

    $timeStamp =  "2019-02-01 06:30:44";
    $timeStampClockIn = new TimeStamp(new UUID('timeStamp'), $timeStamp);

    $timeStamp =  "2019-02-01 09:30:44";
    $timeStampClockOut = new TimeStamp(new UUID('timeStamp'), $timeStamp);

    $userProfile = unserialize($user->user_profile);
    $userLocation = $userProfile->getProfileLocation();

    $clockIn = new ClockIn(new UUID('clockIn'), $timeStampClockIn, $userLocation);
    $clockOut = new ClockOut(new UUID('clockOut'), $timeStampClockOut, $userLocation);

    return [
        'id' => $uuid->toString,
        'user_id' => $user->id,
        'time_sheet_id' => $timeSheet->id,
        'clock_in' =>  serialize($clockIn),
        'clock_out' => serialize($clockOut)
    ];
});
