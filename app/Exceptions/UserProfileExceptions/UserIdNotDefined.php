<?php

namespace App\Exceptions\UserPorfileExceptions;

use Exception;
use App\Exceptions\BuildResponse\BuildResponse;

class UserIdNotDefined extends Exception
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
        $message = 'User\'s name was not defined.';
        $status_code = 409;
        return BuildResponse::build_response($message, $status_code);
    }
}
