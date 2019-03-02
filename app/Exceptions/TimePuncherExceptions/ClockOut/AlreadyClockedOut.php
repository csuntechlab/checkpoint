<?php

namespace App\Exceptions\TimePuncherExceptions\ClockOut;

use Exception;
use App\Exceptions\BuildResponse\BuildResponse;

class AlreadyClockedOut extends Exception
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
        $message = 'User has already clocked out.';
        $status_code = 409;
        return BuildResponse::build_response($message, $status_code);
    }
}
