<?php

use Faker\Generator as Faker;

// Models
use App\Models\UserInvitation;
use App\DomainValueObjects\UUIDGenerator\UUID;
use App\Models\Organization;
use App\Models\Role;

$factory->define(UserInvitation::class, function (Faker $faker) {

    $uuid = new UUID('userInvitation');
    $organizationId = Organization::first();
    $role = Role::where('name', 'Employee')->first();
    $roleId = $role->id;
    $name = $faker->name;
    $email = $faker->email;
    $inviteCode = Token::UniqueNumber('user_invitations','invite_code', 6);

    return [
        'id' => $uuid->toString,
        'organization_id' => $organizationId,
        'role_id' => $roleId,
        'email' => $email,
        'name' => $name,
        'invite_code' => $inviteCode,
    ];
});
