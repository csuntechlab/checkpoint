<?php

namespace App\Exceptions\TimeLogExceptions;

use Exception;
use App\Exceptions\BuildResponse\BuildResponse;

class TimeLogNotFound extends Exception
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
        $message = 'Time Log has not been found.';
        $status_code = 409;
        return BuildResponse::build_response($message, $status_code);
    }
}
