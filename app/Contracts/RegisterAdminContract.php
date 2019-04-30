<?php
namespace App\Contracts;

use App\DomainValueObjects\Location\Address;


interface RegisterAdminContract
{
    public function createAdmin(
        $organizationName,
        Address $address,
        $logo,
        $name,
        $email,
        $password
    );
}
