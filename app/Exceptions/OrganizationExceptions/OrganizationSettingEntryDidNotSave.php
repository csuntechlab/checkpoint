<?php

namespace App\Exceptions\OrganizationExceptions;

use Exception;
use App\Exceptions\BuildResponse\BuildResponse;

class OrganizationSettingEntryDidNotSave extends Exception
{
    private $entry;
    public function __construct($entry)
    {
        $this->entry = $entry;
        parent::__construct();
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @return \Illuminate\Http\Response
     */
    public function render()
    {
        $message = 'Organization Setting ' . $this->entry . ' was not saved.';
        $status_code = 500;
        return BuildResponse::build_response($message, $status_code);
    }
}
