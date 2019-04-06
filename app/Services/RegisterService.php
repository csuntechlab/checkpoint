<?php
namespace App\Services;

use Illuminate\Support\Facades\Hash;

//Models
use App\User;
use App\Models\Organization;
use App\Models\UserInvitation;

//Exceptions
use App\Exceptions\AuthExceptions\UserCreatedFailed;

//Contracts
use App\Contracts\RegisterContract;


class RegisterService implements RegisterContract
{
    public function register($name, $email, $password, $inviteCode): User
    {
        $orgId = $this->getOrganizationIdByUserInvitation($email, $inviteCode);

        try {
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
                'organization_id' => $orgId
            ]);
        } catch (\Exception $e) {
            throw new UserCreatedFailed();
        }

        return $user;
    }



    private function getOrganizationIdByUserInvitation(string $email, string $inviteCode): string
    {
        // $orgId = UserInvitation::where('email', $email)->where('invite_code', $inviteCode)->first();

        //TODO HardCode
        $orgId = Organization::first();

        return $orgId->id;
    }
}
