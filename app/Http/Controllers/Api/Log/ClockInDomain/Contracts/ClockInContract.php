<?php
namespace App\Http\Controllers\Api\Log\ClockInDomain\Contracts;

interface ClockInContract
{
    public function clockIn(string $currentLocation, string $timeStamp);
}
