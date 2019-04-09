<?php
namespace App\Http\Controllers\Api\Auth\RegisterDomain\Services;

use Illuminate\Support\Facades\Hash;
use App\DomainValueObjects\UUIDGenerator\UUID;


//Models
use App\User;
use App\Models\Program;
use App\Models\Organization;
use App\Models\UserInvitation;
use App\DomainValueObjects\Location\Address;

//Exceptions
use App\Exceptions\AuthExceptions\UserCreatedFailed;
use App\Exceptions\OrganizationExceptions\OrganizationCreatedFailed;

//Contracts
use App\Http\Controllers\Api\Auth\RegisterDomain\Contracts\RegisterAdminContract;


class RegisterAdminService implements RegisterAdminContract
{
    public function registerAdminUser(
        $name,
        $email,
        $password,
        $organization_id
      ):User {
        try{
          $user = User::create([
            'organization_id' => $organization_id,
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password)
          ]);
        } catch (\Exception $e) {
          throw new UserCreatedFailed();
        }

        return $user;
      }

    public function registerOrganization(
      $organization_name,
      Address $address,
      $logo
      ):Organization {
        try{
          $organization = Organization::create([
            'id' => UUID::generate(),
            'organization_name' => $organization_name,
            'address' => $address->__toString(),
            'logo' => $logo
          ]);
        } catch (\Exception $e) {
          throw new OrganizationCreatedFailed();
        }

        return $organization;
      }
}
