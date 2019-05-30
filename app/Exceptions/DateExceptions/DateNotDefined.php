<?php
declare (strict_types = 1);
namespace App\Exceptions\DateExceptions;

use Exception;
use App\Exceptions\BuildResponse\BuildResponse;

class DateNotDefined extends Exception
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
        $message = 'Date not defined';
        $status_code = 409;
        return BuildResponse::build_response($message, $status_code);
    }
}
