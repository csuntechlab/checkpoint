<?php

namespace App\Exceptions\OrganizationExceptions;

use Exception;
use App\Exceptions\BuildResponse\BuildResponse;

class OrganizationCreatedFailed extends Exception
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
        $message = 'Organization was not created.';
        $status_code = 500;
        return BuildResponse::build_response($message, $status_code);
    }
}
