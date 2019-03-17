<?php 
namespace App\Http\Controllers\Api\Auth\RegisterDomain\Services;

use Illuminate\Support\Facades\Hash;

//Models
use App\User;
use App\Models\Organization;
use App\Models\UserInvitation;

//Exceptions
use App\Exceptions\AuthExceptions\UserCreatedFailed;

//Contracts
use App\Http\Controllers\Api\Auth\RegisterDomain\Contracts\RegisterContract;


class RegisterService implements RegisterContract
{
    public function register($name, $email, $password, $inviteCode)
    {
        $organizationId  = $this->getOrganizationIdByUserInvitation($email, $inviteCode);

        try {
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
                'organization_id' => $organizationId
            ]);
        } catch (\Exception $e) {
            throw new UserCreatedFailed();
        }

        return $user;
    }



    private function getOrganizationIdByUserInvitation($email, $inviteCode)
    {
        $organizationId = UserInvitation::where('email', $email)->where('invite_code', $inviteCode)->first();

        //TODO HardCode
        $organizationId = Organization::first();

        return $organizationId->id;
    }
}
