<?php
namespace App\Http\Controllers\Api\TimeLog\Logic\Contracts;


use App\DomainValueObjects\TimeLog\ClockIn\ClockIn;

interface ClockInLogicContract
{
    public function verifyUserHasNotYetTimeLogged($userId);

    public function getTimeLogParam($user, $timeStamp): array;

    public function createClockInEntry(string $uuid, $userId, string $timeSheetId, ClockIn $clockIn, string $timeStamp);
}
