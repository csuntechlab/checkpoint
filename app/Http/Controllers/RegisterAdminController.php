<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Auth\RegisterAdminRequest;
use App\Http\Controllers\Controller;
use App\Contracts\RegisterAdminContract;
use App\DomainValueObjects\Location\Address;

class RegisterAdminController extends Controller
{
  protected $registerAdminUtility;

  public function __construct(RegisterAdminContract $registerAdminContract)
  {
    $this->registerAdminUtility = $registerAdminContract;
  }

  public function register(RegisterAdminRequest $request)
  {
    $name = $request['first_name'] . ' ' . $request['last_name'];

    $address = new Address(
      $request['address_number'],
      $request['street'],
      $request['city'],
      $request['state'],
      $request['zip_code']
    );

    $organization = $this->registerAdminUtility->registerOrganization(
      $request['organization_name'],
      $address,
      $request['logo']
    );

    $user = $this->registerAdminUtility->registerAdminUser(
      $name,
      $request['email'],
      $request['password'],
      $organization->id
    );

    return compact(['organization', 'user']);
  }
}
