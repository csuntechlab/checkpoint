<?php

namespace App\Http\Controllers\Api\TimeLog\ClockInDomain;

use App\Http\Controllers\Controller;

use App\Http\Requests\ClockInRequest;

use App\Http\Controllers\Api\TimeLog\ClockInDomain\Contracts\ClockInContract;

class ClockInController extends Controller
{
    protected $clockInUtility;

    public function __construct(ClockInContract $clockInContract)
    {
        $this->clockInUtility = $clockInContract;
    }

    public function clockIn(ClockInRequest $request): array
    {
        return $this->clockInUtility->clockIn($request['date'], $request['time']);
    }
}
