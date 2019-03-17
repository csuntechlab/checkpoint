<?php
namespace App\Http\Controllers\Api\TimeLog\Logic\Contracts;

use App\DomainValueObjects\TimeLog\ClockOut\ClockOut;

interface ClockOutLogicContract
{
    public function getTimeLog($userId, string $logUuid);

    public function getClockOut(string $timeStamp);

    public function appendClockOutToTimeLog($timelog, ClockOut $clockOut, string $timeStamp);
}
