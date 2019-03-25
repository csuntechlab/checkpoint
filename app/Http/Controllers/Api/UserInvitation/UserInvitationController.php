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
        $data = array();

        $data['organizationId'] = (string)$request['organizationId'];

        $data['roleId'] = (string)$request['roleId'];

        $data['name'] = (string)$request['name'];

        $data['email'] = (string)$request['email'];

        return $this->userInvitationUtility->inviteNewUser($data['organizationId'], $data['roleId'], $data['name'], $data['email']);
    }
}
