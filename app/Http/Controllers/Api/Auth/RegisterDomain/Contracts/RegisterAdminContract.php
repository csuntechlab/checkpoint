<?php
namespace App\Http\Controllers\Api\Auth\RegisterDomain\Contracts;
use App\DomainValueObjects\Location\Address;


interface RegisterAdminContract
{
    public function registerOrganization($organization_name, Address $address, $logo);
    public function registerAdminUser($name, $email, $password, $organization_id);
}
