<?php

namespace App\Http\Controllers\Api\Auth\RegisterDomain;

use Illuminate\Http\Request;
use App\Http\Requests\Auth\RegisterAdminRequest;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\Auth\RegisterDomain\Contracts\RegisterContract;
use App\User;

class RegisterAdminController extends Controller
{
    protected $registerAdminUtility;

    public function __contstruct(RegisterContract $registerContract)
    {
        $this->$registerAdminUtility = $registerContract;
    }

    public function register(RegisterAdminRequest $request)
    {
      $name = $request['first_name'].$request['last_name'];

      $address = new Address(
        $request['address_number'],
        $request['street'],
        $request['city'],
        $request['state'],
        $request['zip']
      );

      $organization = $this->registerAdminUtility->registerOrganization(
        $request['organization_name'],
        $address,
        $request['logo']
      );

      $user = $this->registerAdminUtility->registerAdminUser(
        $name,
        $request['email'],
        $password
      );

      return [$organization, $user];
    }
}
