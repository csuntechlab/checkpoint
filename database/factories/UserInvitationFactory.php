<?php

use Faker\Generator as Faker;

// Models
use App\Models\UserInvitation;
use App\DomainValueObjects\UUIDGenerator\UUID;
use App\Models\Program;
use App\Models\Role;

$factory->define(UserInvitation::class, function (Faker $faker) {

    $uuid = new UUID('userInvitation');
    $programId = Program::first();
    $role = Role::where('name', 'Employee')->first();
    $roleId = $role->id;
    $name = $faker->name;
    $email = $faker->email;
    $token = Token::UniqueNumber('user_invitations','token', 6);

    return [
        'id' => $uuid->toString,
        'program_id' => $programId,
        'role_id' => $roleId,
        'email' => $email,
        'name' => $name,
        'token' => $token,
    ];
});
