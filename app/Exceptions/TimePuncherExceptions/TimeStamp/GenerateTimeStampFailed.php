<?php

namespace App\Exceptions\TimePuncherExceptions\TimeStamp;

use Exception;
use App\Exceptions\BuildResponse\BuildResponse;

class GenerateTimeStampFailed extends Exception
{
    public function __contruct()
    {
        parent::__construct();
    }

    /**
     * Render a exception into a HTTP response.
     *
     * @return \Illuminate\Http\Response
     */
    public function render()
    {
        $message = "Generating a TimeStamp Failed";
        $status_code = 409;
        return BuildResponse::build_response($message, $status_code);
    }
}
