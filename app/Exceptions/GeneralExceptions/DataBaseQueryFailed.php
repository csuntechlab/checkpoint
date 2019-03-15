<?php

namespace App\Exceptions\GeneralExceptions;

use Exception;

class DataBaseQueryFailed extends Exception
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
    public function render($subject)
    {
        $message = $subject . ' query failed.';
        dd($message);

        $status_code = 409;
        return BuildResponse::build_response($message, $status_code);
    }
}
