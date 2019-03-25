<?php
namespace App\Http\Controllers\Api\UserInvitation\Services;

// Models

use App\User;
use App\Models\UserInvitation;
use App\DomainValueObjects\UUIDGenerator\UUID;
// Contracts
use App\Http\Controllers\Api\UserInvitation\Contracts\UserInvitationContract;
// Exceptions


use App\Exceptions\UserInvitationExceptions\UserInviteCreationFailed;
use App\Exceptions\UserInvitationExceptions\UserAlreadyRegistered;
use Dirape\Token\Token as DirapeToken;


class UserInvitationService implements UserInvitationContract
{
    public function inviteNewUser($organizationId, $roleId, $name, $email): array
    {
         $this->deletePreviouslyCreatedUserInvitation($email);
        if(!$this->verifyUserIsNotAlreadyRegistered($email)) {
            throw new UserAlreadyRegistered();
        }

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
                throw new UserInviteCreationFailed();
            }
        return [
            "message_success" => "User Invite Was Successful",
            "email" => $email
        ];

    }

    private function deletePreviouslyCreatedUserInvitation($email): bool
    {
        return UserInvitation::where('email', $email)->delete();
    }

    private function verifyUserIsNotAlreadyRegistered($email): bool
    {
        if(User::where('email', $email)->first()){
            return false;
        }
        return true;
    }
}
