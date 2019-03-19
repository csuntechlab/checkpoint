<?php
declare (strict_types = 1);
namespace App\Exceptions\LocationExceptions;

use Exception;
use App\Exceptions\BuildResponse\BuildResponse;

class AddressNotDefined extends Exception
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
        $message = 'Address was not defined';
        $status_code = 409;
        return BuildResponse::build_response($message, $status_code);
    }
}
