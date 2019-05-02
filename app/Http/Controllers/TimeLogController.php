<?php

namespace App\Http\Controllers;
use App\Contracts\TimeLogContract;


//request
use Illuminate\Http\Request;
use App\Http\Requests\TimeLogRequest;

// Date time
use Carbon\Carbon;

class TimeLogController extends Controller
{
    protected $timeLogUtility;

    public function __construct(TimeLogContract $timeLogContract)
    {
        $this->timeLogUtility = $timeLogContract;
    }

    public function getTimeLogByDate(TimeLogRequest $request, $date)
    {
        //
    }
}
