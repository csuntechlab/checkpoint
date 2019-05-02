<?php
namespace App\Services;

//Models
use App\Models\TimeLog;

//Auth
use Illuminate\Support\Facades\Auth;

//Exceptions
use App\Exceptions\TimeSheetExceptions\GetTimeSheetFailed;


//Contracts
use App\Contracts\TimeSheetContract;


class TimeLogService implements TimeLogContract
{
    public function getTimeLogByDate($date)
    {
        //
    }
}
