<?php
namespace App\Http\Controllers\Api\TimeLog\Logic\Contracts;


use App\DomainValueObjects\TimeLog\ClockIn\ClockIn;

interface ClockInLogicContract
{
    public function checkIfIncompleteTimeLogOnThisDate(string $date, string $userId): bool;

    public function getTimeLogParam(string $userId, string $date, string $time): array;

    public function createClockInEntry(
        string $id,
        string $userId,
        string $timeSheetId,
        ClockIn $clockIn,
        string $date,
        string $time
    ): array;
}
