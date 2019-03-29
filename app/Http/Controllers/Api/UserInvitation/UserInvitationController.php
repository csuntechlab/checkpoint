<?php

namespace App\Http\Controllers\Api\UserInvitation;

use Illuminate\Http\Request;
use App\Models\UserInvitation;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\UserInvitation\Contracts\UserInvitationContract;

class UserInvitationController extends Controller
{
    protected $userInvitationUtility;

    public function __construct(UserInvitationContract $userInvitationContract)
    {
        $this->userInvitationUtility = $userInvitationContract;
    }

    public function inviteNewUser(Request $request): array
    {
        $user = Auth::user();

        $orgId = $user->organization_id;

        $roleId = (string)$request['roleId'];

        $name = (string)$request['name'];

        $email = (string)$request['email'];

        return $this->userInvitationUtility->inviteNewUser($orgId, $roleId, $name, $email);
    }
}
