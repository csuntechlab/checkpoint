<?php
namespace App\Http\Controllers\Api\TimeLog\Logic\Contracts;

use App\Models\TimeLog;
use App\DomainValueObjects\TimeLog\ClockOut\ClockOut;

interface ClockOutLogicContract
{
    public function getTimeLog(string $userId, string $logUuid): TimeLog;

    public function getClockOut(string $timeStamp): ClockOut;

    public function appendClockOutToTimeLog($timelog, ClockOut $clockOut, string $timeStamp): array;
}
