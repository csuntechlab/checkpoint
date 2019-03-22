<?php
namespace App\Http\Controllers\Api\UserInvitation\Contracts;

interface UserInvitationContract
{
    public function inviteNewUser($organizationId, $roleId, $name, $email): UserInvitation;
}
