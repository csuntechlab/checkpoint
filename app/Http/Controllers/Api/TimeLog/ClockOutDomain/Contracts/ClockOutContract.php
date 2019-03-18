<?php
namespace App\Http\Controllers\Api\TimeLog\ClockOutDomain\Contracts;

interface ClockOutContract
{
    public function clockOut(string $timeStamp, string $logUuid): array;
}
