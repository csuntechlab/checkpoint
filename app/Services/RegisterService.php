<?php
namespace App\Services;

//Models
use App\Models\UserInvitation;

//Contracts
use App\Contracts\RegisterContract;

// Exceptions
use App\Exceptions\UserInvitationExceptions\UserInvitationNotFound;

// Model Repositories
use App\ModelRepositoryInterfaces\UserModelRepositoryInterface;

use \Illuminate\Support\Facades\DB;

class RegisterService implements RegisterContract
{
    protected $userModelRepo;

    public function __construct(UserModelRepositoryInterface $userRepositoryInterface)
    {
        $this->userModelRepo = $userRepositoryInterface;
    }

    public function register($name, $email, $password, $inviteCode)
    {
        $userInvitation = $this->getOrganizationIdByUserInvitation($email, $inviteCode);

        return DB::transaction(function () use ($name, $email, $password, $userInvitation) {
            $userInvitation->delete();
            return  $this->userModelRepo->create(
                $name,
                $email,
                $password,
                $userInvitation->organization_id,
                $userInvitation->role_id
            );
        });
    }

    private function getOrganizationIdByUserInvitation(string $email, string $inviteCode): UserInvitation
    {
        $userInvitation = UserInvitation::where('email', $email)->where('invite_code', $inviteCode)->firstOrFail();

        if ($userInvitation == null) {
            throw new UserInvitationNotFound();
        }
        return $userInvitation;
    }
}
