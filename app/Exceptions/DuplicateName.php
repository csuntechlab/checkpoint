<?php

namespace App\Exceptions;

use Exception;
use App\Exceptions\BuildResponse\BuildResponse;

class DuplicateName extends Exception
{
    private $displayName;

    public function __construct($displayName)
    {
        $this->displayName = $displayName;
        parent::__construct();
    }

    /**
     * Render an exception into an HTTP response.
     * 
     * @return \Illuminate\Http\Response
     */
    public function render()
    {
        $message = 'Duplicate Entry: ' . $this->displayName . '.';
        $status_code = 409;
        return BuildResponse::build_response($message, $status_code);
    }
}
