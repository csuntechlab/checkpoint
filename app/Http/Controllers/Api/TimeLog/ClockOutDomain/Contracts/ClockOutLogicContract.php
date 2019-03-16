<?php
namespace App\Http\Controllers\Api\TimeLog\ClockOutDomain\Contracts;


interface ClockOutLogicContract
{
    public function getTimeLog($user, $logUuid);

    public function getClockOut($timeStamp);
}
