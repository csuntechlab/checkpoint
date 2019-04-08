<?php
namespace App\ModelRepositoryInterfaces;

// Domain Value Objects
use App\DomainValueObjects\TimeLog\TimeStamp\TimeStamp;

// Models
use App\Models\TimeSheet;

interface TimeLogClockInModelRepositoryInterface
{
    public function userHasIncompleteTimeLogByDate(string $date, string $userId): bool;

    public function getTimeSheet(string $organizationId): TimeSheet;

    public function createClockInEntry(string $userId, string $organizationId, string $timeSheetId, TimeStamp $timeStamp): array;
}
