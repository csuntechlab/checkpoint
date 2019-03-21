<?php
namespace App\Http\Controllers\Api\InviteNewUserDomain\Contracts;

interface InviteNewUserContract
{
    public function inviteNewUser(string $timeStamp): array;
}
