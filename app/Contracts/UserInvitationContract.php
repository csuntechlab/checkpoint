<?php
namespace App\Contracts;

use App\Models\UserInvitation;


interface UserInvitationContract
{
    public function inviteNewUser(string $orgId, string $roleId, string $name, string $email): array;
}
