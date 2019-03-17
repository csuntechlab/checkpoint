<?php
namespace App\Http\Controllers\Api\TimeLog\Logic\Contracts;

use App\DomainValueObjects\TimeLog\ClockOut\ClockOut;

interface ClockOutLogicContract
{
    public function getTimeLog($user, $logUuid);

    public function getClockOut($timeStamp);

    public function appendClockOutToTimeLog($timelog, ClockOut $clockOut, string $timeStamp);
}
