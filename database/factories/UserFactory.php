<?php

use Faker\Generator as Faker;
use App\Organization;
use App\DomainValueObjects\UUIDGenerator\UUID;
use App\DomainValueObjects\UserProfile\UserProfile;
use App\DomainValueObjects\Organization\OrganizationCode\OrganizationCode;
use function Opis\Closure\unserialize;
use function Opis\Closure\serialize;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
 */



$factory->define(App\User::class, function (Faker $faker) {
    $uuid = new UUID('user');
    $organizationCode = 'MetaLab';
    $uuid = new UUID('user');
    $organization = Organization::where('organization_code', $organizationCode)->first();
    $organizationProfile = unserialize($organization->organization_profile);
    $userProfile = new UserProfile($uuid, $organizationProfile);
    return [
        'name' => 'email@email.com',
        'email' => 'email@email.com',
        'email_verified_at' => now(),
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        // 'password' => 'email@email.com', // secret
        'remember_token' => str_random(10),
        'user_profile' => serialize($userProfile),
    ];
});

 