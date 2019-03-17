<?php

namespace App\Exceptions\TimeLogExceptions\ClockIn;

use Exception;
use App\Exceptions\BuildResponse\BuildResponse;

class ClockInWasNotSuccesfullyAdded extends Exception
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Render an exception into an HTTP response.
     * 
     * @return \Illuminate\Http\Response
     */
    public function render()
    {
        $message = 'Clock In was not successfully created.';
        $status_code = 409;
        return BuildResponse::build_response($message, $status_code);
    }
}
