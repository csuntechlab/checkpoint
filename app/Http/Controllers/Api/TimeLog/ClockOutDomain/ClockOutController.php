<?php

namespace App\Http\Controllers\Api\TimeLog\ClockOutDomain;

use App\Http\Requests\ClockOutRequest;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\TimeLog\ClockOutDomain\Contracts\ClockOutContract;

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
