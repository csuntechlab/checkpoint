<?php
namespace App\Contracts;

interface RegisterContract
{
    public function register($name, $email, $password, $inviteCode);
}
