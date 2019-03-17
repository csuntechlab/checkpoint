<?php
namespace App\Http\Controllers\Api\TimeLog\Logic\Contracts;


use App\DomainValueObjects\TimeLog\ClockIn\ClockIn;

interface ClockInLogicContract
{
    public function verifyUserHasNotYetTimeLogged(string $userId): bool;

    public function getTimeLogParam(string $userId, string $timeStamp): array;

    public function createClockInEntry(string $uuid, string $userId, string $timeSheetId, ClockIn $clockIn, string $timeStamp): array;
}
