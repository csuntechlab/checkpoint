<?php
namespace App\Services;

use Illuminate\Support\Facades\Hash;
use App\DomainValueObjects\UUIDGenerator\UUID;


//Models
use App\User;
use App\Models\UserRole;
use App\Models\Role;
use App\Models\Organization;
use App\DomainValueObjects\Location\Address;

//Exceptions
use App\Exceptions\AuthExceptions\UserCreatedFailed;
use App\Exceptions\OrganizationExceptions\OrganizationCreatedFailed;

//Contracts
use App\Contracts\RegisterAdminContract;
use App\Models\OrganizationSettings;

class RegisterAdminService implements RegisterAdminContract
{
  public function registerAdminUser(
    $name,
    $email,
    $password,
    $organization_id
  ) {
    try {
      $user = User::create([
        'organization_id' => $organization_id,
        'name' => $name,
        'email' => $email,
        'password' => Hash::make($password)
      ]);

      $role = UserRole::create([
        'id' => UUID::generate(),
        'user_id' => $user->id,
        'role_id' => 1
      ]);

      $role_name = $user->role()->first();
    } catch (\Exception $e) {
      throw new UserCreatedFailed();
    }

    return [$user, $role, $role_name];
  }

  public function registerOrganization(
    $organization_name,
    Address $address,
    $logo
  ): Organization
  {
    $organizationId = UUID::generate();
    try {
      $organization = Organization::create([
        'id' => $organizationId,
        'organization_name' => $organization_name,
        'address' => $address->__toString(),
        'logo' => $logo
      ]);
      OrganizationSettings::create([
        'organization_id' => $organizationId
      ]);
    } catch (\Exception $e) {
      dd($e);
      throw new OrganizationCreatedFailed();
    }

    return $organization;
  }
}
