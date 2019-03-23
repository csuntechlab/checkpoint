<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\Auth\LoginDomain\Services\LoginService;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function get_private_method($classPath, $function)
    {
        $method = new \ReflectionMethod($classPath, $function);
        $method->setAccessible(true);
        return $method;
    }
}
