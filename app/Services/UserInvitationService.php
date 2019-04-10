<?php
namespace App\Services;

// Models

use App\User;
use App\Models\UserInvitation;
use App\DomainValueObjects\UUIDGenerator\UUID;
// Contracts
use App\Contracts\UserInvitationContract;
// Exceptions


use App\Exceptions\UserInvitationExceptions\UserInviteCreationFailed;
use App\Exceptions\UserInvitationExceptions\UserAlreadyRegistered;
use Dirape\Token\Token as DirapeToken;


class UserInvitationService implements UserInvitationContract
{
    public function inviteNewUser(string $orgId, string $roleId, string $name, string $email): array
    {
        if ($email) {
            if (User::where('email', $email)->first()) {
                throw new UserAlreadyRegistered();
            }
            $this->deletePreviouslyCreatedUserInvitation($email);
        }


        $token = new DirapeToken();
        $token = $token->uniqueNumber('user_invitations', 'invite_code', 6);
        $id = new UUID('userInvitation');
        $id = $id->toString;
        try {
            $userInvitation = UserInvitation::create([
                'id' => $id,
                'organization_id' => $orgId,
                'role_id' => $roleId,
                'name' => $name,
                'email' => $email,
                'invite_code' => $token
            ]);
        } catch (\Exception $e) {

            dd($e);
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
}
