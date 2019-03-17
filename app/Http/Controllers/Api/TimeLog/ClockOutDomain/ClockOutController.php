<?php

namespace App\Http\Controllers\Api\TimeLog\ClockOutDomain;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\TimeLog\ClockOutDomain\Contracts\ClockOutContract;

class ClockOutController extends Controller
{
    protected $clockOutRetriever;

    public function __construct(ClockOutContract $clockOutContract)
    {
        $this->clockOutRetriever = $clockOutContract;
    }

    public function getParam($request): array
    {
        $data = array();

        $data['timeStamp'] = (string)$request['timeStamp'];

        $data['logUuid'] = $request['logUuid'];

        return $data;
    }


    public function clockOut(Request $request): array
    {
        $data = $this->getParam($request);

        return $this->clockOutRetriever->clockOut($data['timeStamp'], $data['logUuid']);
    }
}
