<?php

namespace App\Http\Controllers\Api\Log\ClockOutDomain;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\Log\ClockOutDomain\Contracts\ClockOutContract;

class ClockOutController extends Controller
{
    protected $clockOutRetriever;

    public function __construct(ClockOutContract $clockOutContract)
    {
        $this->clockOutRetriever = $clockOutContract;
    }


    public function clockOut(Request $request)
    {
        return $this->clockOutRetriever->clockOut($request);
    }
}
