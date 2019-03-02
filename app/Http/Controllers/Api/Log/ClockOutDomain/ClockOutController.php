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

    public function getParam($request): array
    {
        $data = array();

        $data['currentLocation'] = (string)$request['currentLocation'];

        $data['timeStamp'] = (string)$request['timeStamp'];

        $data['logUuid'] = $request['logUuid'];

        return $data;
    }


    public function clockOut(Request $request)
    {
        $data = $this->getParam($request);

        return $this->clockOutRetriever->clockOut($data['currentLocation'], $data['timeStamp'], $data['logUuid']);
    }
}
