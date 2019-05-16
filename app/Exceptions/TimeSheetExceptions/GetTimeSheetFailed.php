<?php

namespace App\Exceptions\TimeSheetExceptions;

use Exception;
use App\Exceptions\BuildResponse\BuildResponse;

class GetTimeSheetFailed extends Exception
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
        $message = 'Get Time Sheet failed.';
        $status_code = 500;
        return BuildResponse::build_response($message, $status_code);
    }
}
