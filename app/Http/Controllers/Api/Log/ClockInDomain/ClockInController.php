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

    private function getParam($request): array
    {
        $data = array();
        $data['currentLocation'] = (string)$request['currentLocation'];
        $data['timeStamp'] = (string)$request['timeStamp'];
        return $data;
    }


    public function clockIn(Request $request)
    {
        $data = $this->getParam($request);
        return $this->clockInRetriever->clockIn($data['currentLocation'], $data['timeStamp']);
    }
}