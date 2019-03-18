<?php

namespace App\Exceptions\GeneralExceptions;

use Exception;
use App\Exceptions\BuildResponse\BuildResponse;

class DataBaseQueryFailed extends Exception
{
    private $subject;
    public function __construct($subject)
    {
        $this->subject = $subject;
        parent::__construct();
    }

    /**
     * Render an exception into an HTTP response.
     * 
     * @return \Illuminate\Http\Response
     */
    public function render()
    {
        $message = $this->subject . 'query failed.';

        $status_code = 409;
        return BuildResponse::build_response($message, $status_code);
    }
}
