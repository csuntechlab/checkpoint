<?php
declare (strict_types = 1);
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

// Requests
use App\Http\Requests\ClockInRequest;

// Contracts
use App\Contracts\ClockInContract;

class ClockInController extends Controller
{
    protected $clockInUtility;

    public function __construct(ClockInContract $clockInContract)
    {
        $this->clockInUtility = $clockInContract;
    }

    public function clockIn(ClockInRequest $request): array
    {
        $this->clockInUtility->clockIn($request['date'], $request['time']);
    }
}
