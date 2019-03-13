<?php 
namespace App\Http\Controllers\Api\Auth\RegisterDomain\Services;

use App\User;
use App\UserInvitation;
use Illuminate\Support\Facades\Hash;

use App\DomainValueObjects\UUIDGenerator\UUID;
use App\DomainValueObjects\UserProfile\UserProfile;
use App\DomainValueObjects\Organization\OrganizationCode\OrganizationCode;


use App\Http\Controllers\Api\Auth\RegisterDomain\Contracts\RegisterContract;
use function Opis\Closure\unserialize;
use function Opis\Closure\serialize;


class RegisterService implements RegisterContract
{
    private $domainName = "user";

    public function register($name, $email, $password, $inviteCode)
    {
        $uuid = new UUID($this->domainName);
        $organizationId  = $this->getOrganizationIdByUserInvitation($email, $inviteCode);

        $userProfile = new UserProfile($uuid, $organizationProfile);

        try {
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
                'user_profile' => serialize($userProfile)
            ]);
        } catch (Illuminate\Database\QueryException $e) {
            return ['message_error' => 'User was not successfully created.'];
        }

        return $user;
    }

    private function getOrganizationIdByUserInvitation($email, $inviteCode)
    {
        $organizationId = UserInvitation::where('invite_code', $inviteCode)->first();
        $organizationProfile = unserialize($organization->organization_profile);
        return $organizationProfile;
    }
}
