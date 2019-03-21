<?php

namespace App\Http\Controllers\Api\UserInvitation\InviteNewUserDomain;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\UserInvitation\InviteNewUserDomain\InviteNewUserContract;

class InviteNewUserController extends Controller
{
    protected $inviteNewUserUtility;

    public function __construct(InviteNewUserContract $InviteNewUserContract)
    {
        $this->inviteNewUserUtility = $InviteNewUserContract;
    }
}
