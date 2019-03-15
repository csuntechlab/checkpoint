<?php

namespace App\Exceptions\AuthExceptions;

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
        $message = 'User was not succesfully created';
        $status_code = 409;
        return BuildResponse::build_response($message, $status_code);
    }
}
