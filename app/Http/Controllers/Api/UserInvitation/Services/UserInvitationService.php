<?php
namespace App\Http\Controllers\Api\UserInvitation\Services;

// Models

use App\Models\UserInvitation;
// use \Dirape\Token;
// Contracts
use App\Http\Controllers\Api\UserInvitation\Contracts\UserInvitationContract;
// Exceptions
use Dirape\Token\Token;

use App\Exceptions\UserInvitationExceptions\UserInviteCreatedFailed;


class UserInvitationService implements UserInvitationContract
{
    public function inviteNewUser($organizationId, $roleId, $name, $email): UserInvitation
    {
        $token = Token::UniqueNumber('user_invitations', 'invite_code', 6);
        dd($token);
        try {
            $userInvitation = UserInvitation::create([
                'organization_id' => $organizationId,
                'role_id' => $roleId,
                'name' => $name,
                'email' => $email,
                'token' => $token
            ]);
        } catch (\Exception $e) {
            dd($e);
            throw new UserInviteCreatedFailed();
        }
        return $userInvitation;
    }
}
