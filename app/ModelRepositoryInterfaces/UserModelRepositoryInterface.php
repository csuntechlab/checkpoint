<?php
namespace App\ModelRepositoryInterfaces;

interface UserModelRepositoryInterface
{
    public function create(string $name, string  $email, string  $password, string $organizationId, int $roleId);
}
