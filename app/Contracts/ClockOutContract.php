<?php
namespace App\Contracts;

interface ClockOutContract
{
    public function clockOut(string $date, string $time, string $logId): array;
}
