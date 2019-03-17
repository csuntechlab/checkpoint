<?php

namespace App\Http\Controllers\Api\TimeLog\ClockInDomain;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\TimeLog\ClockInDomain\Contracts\ClockInContract;

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

        $data['timeStamp'] = (string)$request['timeStamp'];

        return $data;
    }

    public function clockIn(Request $request): array
    {
        $data = $this->getParam($request);

        return $this->clockInRetriever->clockIn($data['timeStamp']);
    }
}
