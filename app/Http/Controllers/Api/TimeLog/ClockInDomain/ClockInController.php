<?php

namespace App\Http\Controllers\Api\TimeLog\ClockInDomain;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\TimeLog\ClockInDomain\Contracts\ClockInContract;

class ClockInController extends Controller
{
    protected $clockInUtility;

    public function __construct(ClockInContract $clockInContract)
    {
        $this->clockInUtility = $clockInContract;
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

        return $this->clockInUtility->clockIn($data['timeStamp']);
    }
}
