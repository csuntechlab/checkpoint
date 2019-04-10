<?php
namespace App\Contracts;

use App\DomainValueObjects\TimeLog\TimeStamp\TimeStamp;

interface ClockInContract
{
    public function clockIn(string $date, string $time);
}
