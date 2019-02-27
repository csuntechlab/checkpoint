<?php
namespace App\Http\Controllers\Api\Log\TimePuncher\Contracts;

interface TimePuncherContract
{
    public function getUserLocationAndUserTimeSheetId($user, $currentLocation): array;
}
