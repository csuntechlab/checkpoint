<?php
namespace App\Http\Controllers\Api\UserInvitation\Contracts;

use App\Models\UserInvitation;


interface UserInvitationContract
{
    public function inviteNewUser(string $orgId, string $roleId, string $name, string $email): array;

}
