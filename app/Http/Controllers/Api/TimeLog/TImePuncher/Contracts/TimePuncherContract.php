<?php
namespace App\Http\Controllers\Api\TimeLog\TimePuncher\Contracts;

interface TimePuncherContract
{
    public function getTimeSheetId($user);
}
