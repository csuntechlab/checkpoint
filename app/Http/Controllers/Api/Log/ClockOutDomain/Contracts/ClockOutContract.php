<?php
namespace App\Http\Controllers\Api\Log\ClockOutDomain\Contracts;

interface ClockOutContract
{
    public function clockOut(string $currentLocation, string $timeStamp, string $logUuid);
}
