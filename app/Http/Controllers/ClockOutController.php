<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

// Request
use App\Http\Requests\ClockInOutRequest;

// Contract
use App\Contracts\ClockOutContract;
use App\Models\TimeLog;

class ClockOutController extends Controller
{
    protected $clockOutUtility;

    public function __construct(ClockOutContract $clockOutContract)
    {
        $this->clockOutUtility = $clockOutContract;
    }

    public function clockOut(ClockInOutRequest $request, TimeLog $timeLog): array
    {
        dd($timeLog);
        return $this->clockOutUtility->clockOut($request['date'], $request['time'], $request['logId']);
    }
}
