<?php
namespace App\Services;

use Illuminate\Support\Facades\Hash;
use \Illuminate\Support\Facades\DB;

// Domain Value Objects
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
use App\Models\OrganizationSetting;

// Model Repos
use App\ModelRepositoryInterfaces\UserModelRepositoryInterface;

class RegisterAdminService implements RegisterAdminContract
{

  protected $userModelRepo;

  public function __construct(UserModelRepositoryInterface $userRepositoryInterface)
  {
    $this->userModelRepo = $userRepositoryInterface;
  }

  public function createAdmin($organizationName, Address $address, $logo, $name, $email, $password)
  {
    return DB::transaction(function () use ($organizationName,  $address, $logo, $name, $email, $password) {
      $organization = $this->createOrganization($organizationName, $address, $logo);
      $adminRoleId = 1;
      $user = $this->userModelRepo->create(
        $name,
        $email,
        $password,
        $organization->id,
        $adminRoleId
      );
      $role = $user['role'];
      $user = $user['user'];
      return compact(['user', 'role', 'organization']);
    });
  }

  public function createOrganization(
    $organizationName,
    Address $address,
    $logo
  ): Organization
  {
    $organizationId = UUID::generate();
    try {
      $organization = Organization::create([
        'id' => $organizationId,
        'organization_name' => $organizationName,
        'address' => $address->__toString(),
        'logo' => $logo
      ]);
      OrganizationSetting::create([
        'organization_id' => $organizationId
      ]);
    } catch (\Exception $e) {
      dd($e);
      throw new OrganizationCreatedFailed();
    }

    return $organization;
  }
}
