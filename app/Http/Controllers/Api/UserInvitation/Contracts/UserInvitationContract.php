<?php
namespace App\Http\Controllers\Api\UserInvitation\Contracts;

use App\Models\UserInvitation;


interface UserInvitationContract
{
    public function inviteNewUser($organizationId, $roleId, $name, $email): String;

}
