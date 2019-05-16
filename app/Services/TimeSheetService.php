<?php
namespace App\Services;

use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

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
    public function getTimeSheetByDate($date)
    {
        try{
            $id = Auth::User()->organization_id;

            $timeSheet = TimeSheet::getTimeSheet($date, $id)->firstOrFail();
        } catch (\Exception $e) {
            throw new GetTimeSheetFailed();
        }

        return $timeSheet;
    }

    public function getCurrentTimeSheet()
    {
        try{
            $id = Auth::User()->organization_id;
            $date = Carbon::now();

            $timeSheet = TimeSheet::getTimeSheet($date, $id)->firstOrFail();
        } catch (\Exception $e) {
            throw new GetTimeSheetFailed();
        }

        return $timeSheet;
    }
}
