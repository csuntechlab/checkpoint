<?php
namespace App\Http\Controllers\Api\Auth\RegisterDomain\Contracts;

interface RegisterContract
{
    public function register(string $name, string $email, string $password, string $inviteCode);
}
