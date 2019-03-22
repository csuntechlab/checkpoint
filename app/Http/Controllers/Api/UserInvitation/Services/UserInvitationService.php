<?php
namespace App\Http\Controllers\Api\UserInvitation\Services;

// Models
use App\Models\UserInvitation;
Use DirapeToken;
// Contracts
use App\Http\Controllers\Api\UserInvitation\Contracts\UserInvitationContract;

// Exceptions
use App\Exceptions\UserInvitationExceptions\UserInviteCreationFailed;


class UserInvitationService implements UserInvitationContract
{
    public function inviteNewUser($organizationId, $roleId, $name, $email): UserInvitation
    {
        try {
            $userInvitation = UserInvitation::create([
                'organization_id' => $organizationId,
                'role_id' => $roleId,
                'name' => $name,
                'email' => $email,
                'token' => Token::UniqueNumber('user_invitations', 'invite_code', 6)
            ]);
        } catch (\Exception $e) {
            throw new UserInviteCreationFailed();
        }
        return $userInvitation;
    }
}
