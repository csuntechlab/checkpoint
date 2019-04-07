<?php
namespace App\ModelRepositoryInterfaces;


use App\DomainValueObjects\TimeLog\ClockIn\ClockIn;

interface TimeLogClockInModelRepositoryInterface
{
    public function userHasIncompleteTimeLogByDate(string $date, string $userId): bool;

    public function getTimeLogParam(string $userId, string $date, string $time): array;

    public function createClockInEntry(
        string $id,
        string $userId,
        string $organizationId,
        string $timeSheetId,
        ClockIn $clockIn,
        string $date,
        string $time
    ): array;
}
