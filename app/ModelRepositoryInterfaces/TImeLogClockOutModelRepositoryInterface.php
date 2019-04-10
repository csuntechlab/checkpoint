<?php
namespace App\ModelRepositoryInterfaces;

use App\DomainValueObjects\TimeLog\TimeStamp\TimeStamp;

use App\Models\TimeLog;
use Carbon\Carbon;

interface TImeLogClockOutModelRepositoryInterface
{
    public function getTimeLog(string $userId, string $logId): TimeLog;
}
