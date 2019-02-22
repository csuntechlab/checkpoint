<?php 
namespace App\Http\Controllers\Api\Auth\RegisterDomain\Services;

use App\User;
use App\Organization;
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

    public function register($request)
    {
        try {
            $name = (string)$request['name'];
            $email = (string)$request['email'];
            $password = (string)$request['password'];
        } catch (\Exception $e) {
            return ['message_error' => 'User was not successfully created.'];
        }

        $organizationCode = 'MetaLab';
        $uuid = new UUID($this->domainName);
        $organizationProfile  = $this->getOrganizationProfile($organizationCode);

        $userProfile = new UserProfile($uuid, $organizationProfile);

        try {
            $user = User::create([
                'id' => $uuid->toString,
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

    private function getOrganizationProfile($organizationCode)
    {
        //validate organization code 

        $organization = Organization::where('organization_code', $organizationCode)->first();
        $organizationProfile = unserialize($organization->organization_profile);
        return $organizationProfile;
    }
}
