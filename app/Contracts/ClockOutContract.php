<?php
namespace App\Contracts;

use App\Models\TimeLog;

interface ClockOutContract
{
    public function clockOut(string $date, string $time, TimeLog $timeLog): array;
}
