<?php
namespace App\Http\Controllers\Api\TimeLog\ClockInDomain\Contracts;


interface ClockInLogicContract
{
    public function getTimeLogParam($user, $timeStamp): array;

    public function verifyUserHasNotYetTimeLogged($userId);
}
