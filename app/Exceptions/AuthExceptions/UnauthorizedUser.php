<?php

namespace App\Exceptions\AuthExceptions;

use Exception;
use App\Exceptions\BuildResponse\BuildResponse;

class UnauthorizedUser extends Exception
{
    protected $role;

    public function __construct($role)
    {
        $this->role = $role;
        parent::__construct();
    }

    /**
     * Render an exception into an HTTP response.
     * 
     * @return \Illuminate\Http\Response
     */
    public function render()
    {
        $message = 'Unauthorized access. User is not ' . $this->role . '.';
        $status_code = 401;
        return BuildResponse::build_response($message, $status_code);
    }
}
