<?php

namespace App\Http\Controllers\Api\UserInvitation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\UserInvitation\Contracts\UserInvitationContract;

class UserInvitationController extends Controller
{
    protected $userInvitationUtility;

    public function __construct(UserInvitationContract $userInvitationContract)
    {
        $this->userInvitationUtility = $userInvitationContract;
    }

    private function getParam($request): array
    {
        $data = array();

        $data['organizationId'] = (string)$request['organizationId'];

        $data['roleId'] = (string)$request['roleId'];

        $data['name'] = (string)$request['name'];

        $data['email'] = (string)$request['email'];

        return $data;
    }

    public function clockIn(Request $request): array
    {
        $data = $this->getParam($request);

        return $this->userInvitationUtility->inviteNewUser($data['organizationId'], $data['roleId'], $data['name'], $data['email']);
    }
}
