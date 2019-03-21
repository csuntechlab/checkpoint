<?php
namespace App\Http\Controllers\Api\UserInvitation\InviteNewUserDomain\Services;

// Auth
use Illuminate\Support\Facades\Auth;

// Contracts
use App\Http\Controllers\Api\UserInvitation\InviteNewUserDomain\Contracts\UserInvitationContract;

class InviteNewUserService implements UserInvitationContract
{
    protected $userInvitationUtility;

    public function __construct(UserInvitationContract $userInvitationUtility)
    {
        $this->userInvitationUtility = $userInvitationUtility;
    }

    public function inviteNewUser(string $timeStamp): array
    {
        $user = Auth::user();
        $userId = $user->id;
    }

    public function verifyUserRoleIsAdmin(string $userId): bool
    {
        $user = Auth::user();
        $userId = $user->id;
    }

}

