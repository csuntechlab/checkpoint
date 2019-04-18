<?php

namespace App\Exceptions\LocationExceptions;

use Exception;
use App\Exceptions\BuildResponse\BuildResponse;

class UserCreatedFailed extends Exception
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
        $message = 'Project Location was not updated.';
        $status_code = 500;
        return BuildResponse::build_response($message, $status_code);
    }
}
