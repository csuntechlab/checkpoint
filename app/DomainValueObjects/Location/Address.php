<?php
declare (strict_types = 1);
namespace App\DomainValueObjects\Location;

use App\Exceptions\LocationExceptions\InvalidAddress;


class Address
{
    private $address_number;
    private $street;
    private $city;
    private $state;
    private $zip;

    public function __construct(
      String $address_number = null,
      String $street = null,
      String $city = null,
      String $state = null,
      String $zip = null
    ) {
      $this->address_number = $address_number;
      $this->street = $street;
      $this->city = $city;
      $this->state = $state;
      $this->zip = $zip;
      $this->validate();
    }

    private function validate()
    {
        if(
          $this->address_number == null ||
          $this->street == null ||
          $this->city == null ||
          $this->state == null ||
          $this->zip == null
        ){
          throw new InvalidAddress();
        }
    }
}
