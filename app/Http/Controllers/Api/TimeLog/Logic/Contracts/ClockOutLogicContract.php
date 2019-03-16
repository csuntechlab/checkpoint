<?php
namespace App\Http\Controllers\Api\TimeLog\Logic\Contracts;


interface ClockOutLogicContract
{
    public function getTimeLog($user, $logUuid);

    public function getClockOut($timeStamp);
}
