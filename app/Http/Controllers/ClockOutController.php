<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

// Request
use App\Http\Requests\ClockOutRequest;

// Contract
use App\Contracts\ClockOutContract;

class ClockOutController extends Controller
{
    protected $clockOutUtility;

    public function __construct(ClockOutContract $clockOutContract)
    {
        $this->clockOutUtility = $clockOutContract;
    }

    public function clockOut(ClockOutRequest $request): array
    {
        return $this->clockOutUtility->clockOut($request['date'], $request['time'], $request['logId']);
    }
}
