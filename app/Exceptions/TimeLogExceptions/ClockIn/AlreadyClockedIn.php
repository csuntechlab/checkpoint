<?php

namespace App\Exceptions\TimeLogExceptions\ClockIn;

use Exception;
use App\Exceptions\BuildResponse\BuildResponse;

class AlreadyClockedIn extends Exception
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
        $message = 'User has already clocked in.';
        $status_code = 409;
        return BuildResponse::build_response($message, $status_code);
    }
}
