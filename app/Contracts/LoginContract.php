<?php
namespace App\Contracts;

interface LoginContract
{
    public function login(string $email, string $password);
}
