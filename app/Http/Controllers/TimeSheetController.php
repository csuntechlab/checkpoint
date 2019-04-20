<?php

namespace App\Http\Controllers;
use App\Contracts\TimeSheetContract;
use App\User;

// Request
use Illuminate\Http\Request;
use App\Http\Requests\TimeSheetRequest;

// Date time
use Carbon\Carbon;

class TimeSheetController extends Controller
{
    protected $timeSheetUtility;

    public function __construct(TimeSheetContract $timeSheetContract)
    {
        $this->timeSheetUtility = $timeSheetContract;
    }

    public function getCurrentTimeSheet(TimeSheetRequest $request)
    {

        $date = Carbon::parse($request['date']);

        return $this->timeSheetUtility->getCurrentTimeSheet($date);
    }
}
