<?php
namespace App\Contracts;


interface UserContract
{
    public function profile(int $userId);
}
