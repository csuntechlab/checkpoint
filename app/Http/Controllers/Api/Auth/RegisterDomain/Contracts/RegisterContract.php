<?php
namespace App\Http\Controllers\Api\Auth\RegisterDomain\Contracts;

interface RegisterContract
{
    public function register($name, $email, $password, $inviteCode);
}
