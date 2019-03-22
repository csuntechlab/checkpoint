<?php
namespace App\Http\Controllers\Api\UserInvitation\Services;

// Models

use App\Models\UserInvitation;
use App\DomainValueObjects\UUIDGenerator\UUID;
// use \Dirape\Token;
// Contracts
use App\Http\Controllers\Api\UserInvitation\Contracts\UserInvitationContract;
// Exceptions


use App\Exceptions\UserInvitationExceptions\UserInviteCreatedFailed;
use Dirape\Token\Token as DirapeToken;


class UserInvitationService implements UserInvitationContract
{
    public function inviteNewUser($organizationId, $roleId, $name, $email): UserInvitation
    {
        $token = new DirapeToken();
        $token = $token->uniqueNumber('user_invitations', 'invite_code', 6);
        $id = new UUID('userInvitation');
        $id = $id->toString;
        try {
            $userInvitation = UserInvitation::create([
                'id' => $id,
                'organization_id' => $organizationId,
                'role_id' => $roleId,
                'name' => $name,
                'email' => $email,
                'invite_code' => $token
            ]);
        } catch (\Exception $e) {
            throw new UserInviteCreatedFailed();
        }
        return $userInvitation;
    }
}
