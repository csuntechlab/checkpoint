<?php

namespace App\Exceptions\UUIDExceptions;

use Exception;

class GenerateUUID5Failed extends Exception
{
    public function __construct()
    {
        parent::__construct();
    }
}
