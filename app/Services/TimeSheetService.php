<?php
namespace App\Services;

use Illuminate\Support\Facades\Hash;

//Models
use App\Models\TimeSheet;
//Auth
use Illuminate\Support\Facades\Auth;
//Exceptions
use App\Exceptions\TimeSheetExceptions\GetTimeSheetFailed;


//Contracts
use App\Contracts\TimeSheetContract;


class TimeSheetService implements TimeSheetContract
{
    public function getCurrentTimeSheet($date)
    {
        try{
            $id = Auth::User()->organization_id;

            $timeSheet = TimeSheet::getCurrentTimeSheet($date, $id)->firstOrFail();
        } catch (\Exception $e) {
            throw new GetTimeSheetFailed();
        }

        return $timeSheet;
    }
}
