<?php
namespace App\Http\Controllers\Api\Auth\LogoutDomain\Contracts;

interface LogoutContract
{
    public function logout($request);
}
