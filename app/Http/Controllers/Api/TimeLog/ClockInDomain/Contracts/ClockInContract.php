<?php
namespace App\Http\Controllers\Api\TimeLog\ClockInDomain\Contracts;

interface ClockInContract
{
    public function clockIn(string $date, string $time): array;
}
