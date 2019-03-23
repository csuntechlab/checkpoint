<?php
namespace App\Http\Controllers\Api\TimeLog\ClockOutDomain\Contracts;

interface ClockOutContract
{
    public function clockOut(string $date, string $time, string $logId): array;
}
