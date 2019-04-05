<?php
namespace App\Http\Controllers\Api\Auth\RegisterDomain\Contracts;

interface RegisterAdminContract
{
    public function registerOrganization($organization_name, $address, $logo);
    public function registerAdminUser($name, $email, $password);
}
