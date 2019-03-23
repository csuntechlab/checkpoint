<?php
namespace App\Http\Controllers\Api\TimeLog\Logic\Contracts;

use App\Models\TimeLog;
use App\DomainValueObjects\TimeLog\ClockOut\ClockOut;

interface ClockOutLogicContract
{
    public function getTimeLog(string $userId, string $logId): TimeLog;

    public function getClockOut(string $date, string $time): ClockOut;

    public function appendClockOutToTimeLog(TimeLog $timelog, ClockOut $clockOut, string $date, string $time): array;
}
