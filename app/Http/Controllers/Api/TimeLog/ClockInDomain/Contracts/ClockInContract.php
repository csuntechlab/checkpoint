<?php
namespace App\Http\Controllers\Api\TimeLog\ClockInDomain\Contracts;

interface ClockInContract
{
    public function clockIn(string $timeStamp): array;
}
