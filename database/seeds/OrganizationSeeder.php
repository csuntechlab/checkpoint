<?php

use Illuminate\Database\Seeder;


use Faker\Generator as Faker;

use App\DomainValueObjects\UUIDGenerator\UUID;
use App\DomainValueObjects\Location\Address;

use App\Models\Organization;
use App\Models\OrganizationSettings;
use App\Models\PayPeriodType;
use App\Models\TimeCalculatorType;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {

        for ($i = 0; $i < 3; $i++) {
            $organizationName = $faker->company;
            $streetNumber = (string)$faker->biasedNumberBetween($min = 0, $max = 9999);
            $streetName = $faker->streetName;
            $city = $faker->city;
            $state = $faker->state;
            $postCode = $faker->postcode;
            $logoLocation = "/data/" . $organizationName . ".jpeg";
            $address = new Address($streetNumber, $streetName, $city, $state, $postCode);
            $orgId = UUID::generate();

            Organization::create([
                'id' => $orgId,
                'organization_name' => $organizationName,
                'address' => $address->__toString(),
                'logo' => $logoLocation
            ]);

            OrganizationSettings::create([
                'id' => UUID::generate(),
                'organization_id' =>  $orgId,
                'pay_period_type_id' =>  PayPeriodType::all()->random()->id,
                'time_calculator_type_id' =>  TimeCalculatorType::all()->random()->id,
                'radius' => 25.34
            ]);
        }
    }
}
