<?php 
namespace App\Http\Controllers\Api\Log\ClockInDomain\Services;

use function Opis\Closure\serialize;
use function Opis\Closure\unserialize;

use App\Http\Controllers\Api\Log\ClockInDomain\Contracts\ClockInContract;

class ClockInService implements ClockInContract
{
    private $domainName = "ClockIn";

    public function clockIn($request)
    {
        dd($request);
        dd('clockIn');
    }
}

 