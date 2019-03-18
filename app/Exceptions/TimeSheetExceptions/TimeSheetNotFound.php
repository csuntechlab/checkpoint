<?php

namespace App\Exceptions\TimeSheetExceptions;

use Exception;
use App\Exceptions\BuildResponse\BuildResponse;

class TimeSheetNotFound extends Exception
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
        $message = 'Time Sheet was not found.';
        $status_code = 409;
        return BuildResponse::build_response($message, $status_code);
    }
}
