<?php
namespace App\ModelRepositories;

use Illuminate\Support\Facades\Hash;

// Domain Value Object
use App\DomainValueObjects\UUIDGenerator\UUID;

//Models
use App\User;
use App\Models\UserRole;

//Exceptions 
use App\Exceptions\AuthExceptions\UserCreatedFailed;

// Contracts 
use App\ModelRepositoryInterfaces\UserModelRepositoryInterface;

class UserModelRepository implements UserModelRepositoryInterface
{
    public function assignRole(User $user, int $roleId)
    {
        $role = UserRole::create([
            'id' => UUID::generate(),
            'user_id' => $user->id,
            'role_id' => $roleId
        ]);

        $userRoles = $user->role()->first();

        return $userRoles;
    }

    public function create(string $name, string  $email, string  $password, string $organizationId, int $roleId)
    {
        $user = User::create([
            'organization_id' => $organizationId,
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password)
        ]);
        $role = $this->assignRole($user, $roleId);
        return compact(['user', 'role']);
    }
}
