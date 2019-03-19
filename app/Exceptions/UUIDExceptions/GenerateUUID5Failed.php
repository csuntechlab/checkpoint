<?php

namespace App\Exceptions\UUIDExceptions;

use Exception;
use App\Exceptions\BuildResponse\BuildResponse;

class GenerateUUID5Failed extends Exception
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
        $message = 'Generating a UUID failed.';
        $status_code = 409;
        return BuildResponse::build_response($message, $status_code);
    }
}
