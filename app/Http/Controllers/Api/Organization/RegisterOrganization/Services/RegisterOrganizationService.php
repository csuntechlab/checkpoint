<?php 
namespace App\Http\Controllers\Api\Organization\Services;

use App\User;
use Illuminate\Support\Facades\Hash;

use DomainValueObjects\UUIDGenerator\UUID;

use App\Http\Controllers\Api\Organization\Contracts\RegisterOrganizationContract;


class RegisterOrganizationService implements RegisterOrganizationContract
{
    private $domainName = "user";

    public function register($request)
    { }
}
