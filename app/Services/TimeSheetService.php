<?php
namespace App\Services;

use Illuminate\Support\Facades\Hash;

//Models
use App\TimeSheet;

//Exceptions
use App\Exceptions\TimeSheetExceptions\GetTimeSheetFailed;


//Contracts
use App\Contracts\TimeSheetContract;


class TimeSheetService implements TimeSheetContract
{
    public function getCurrentTimeSheet($date)
    {
        try{
            $timeSheet = TimeSheet::getCurrentTimeSheet($date)->get();
        } catch (\Exception $e) {
            throw new GetTimeSheetFailed();
        }

        return $timeSheet;
    }
}
