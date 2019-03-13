<?php
namespace App\Http\Controllers\Api\TimeLog\TimePuncher\Contracts;

interface TimePuncherContract
{
    public function getUserLocationAndUserTimeSheetId($user, $currentLocation): array;
    public function getUserLocation($user, $currentLocation);
}
