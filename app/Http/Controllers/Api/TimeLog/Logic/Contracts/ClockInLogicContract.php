<?php
namespace App\Http\Controllers\Api\TimeLog\Logic\Contracts;


interface ClockInLogicContract
{
    public function getTimeLogParam($user, $timeStamp): array;

    public function verifyUserHasNotYetTimeLogged($userId);
}
