<?php
namespace App\Http\Controllers\Api\Auth\RegisterDomain\Services;

use Illuminate\Support\Facades\Hash;

//Models
use App\User;
use App\Models\Program;
use App\Models\Organization;
use App\Models\UserInvitation;
use App\DomainValueObjects\Location\Address;

//Exceptions
use App\Exceptions\AuthExceptions\UserCreatedFailed;

//Contracts
use App\Http\Controllers\Api\Auth\RegisterDomain\Contracts\RegisterAdminContract;


class RegisterAdminService implements RegisterContract
{
    public function registerAdminUser(
        $name,
        $email,
        $password
      ):User {
        try{
          $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
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
            'organization_name' => $organization_name,
            'address' => get_object_vars($address),
            'logo' => $logo
          ]);
        } catch (\Exception $e) {
          throw new OrganizationCreatedFailed();
        }

        return $organization;
      }
}
