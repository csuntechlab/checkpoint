<?php

namespace App\Exceptions\OrganizationExceptions;

use Exception;
use App\Exceptions\BuildResponse\BuildResponse;

class OrganizationSettingHasEntryException extends Exception
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
        $message = 'Organization Settings has been created already.';
        $status_code = 409;
        return BuildResponse::build_response($message, $status_code);
    } //
}
