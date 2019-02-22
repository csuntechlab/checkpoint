<?php

namespace App\Http\Controllers\Api\Log\ClockInDomain;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\Log\ClockInDomain\Contracts\ClockInContract;

class ClockInController extends Controller
{
    protected $clockInRetriever;

    public function __construct(ClockInContract $clockInContract)
    {
        $this->clockInRetriever = $clockInContract;
    }


    public function clockIn(Request $request)
    {
        return $this->clockInRetriever->clockIn($request);
    }
}
