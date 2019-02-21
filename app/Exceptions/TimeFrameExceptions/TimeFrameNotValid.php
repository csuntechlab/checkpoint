<?php

namespace App\Exceptions;

use Exception;

class TimeFrameNotValid extends Exception
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
        $message = 'Time Frame was not valid.';
        $status_code = 409;
        return BuildResponse::build_response($message, $status_code);
    }
}
