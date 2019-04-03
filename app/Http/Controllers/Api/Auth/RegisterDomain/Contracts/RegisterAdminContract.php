<?php
namespace App\Http\Controllers\Api\Auth\RegisterDomain\Contracts;

interface RegisterAdminContract
{
    public function registerOrganization();
    public function registerAdminUser();
}
