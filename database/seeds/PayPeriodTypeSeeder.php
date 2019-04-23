<?php

use Illuminate\Database\Seeder;

use App\Models\PayPeriodType;
use App\DomainValueObjects\UUIDGenerator\UUID;

use Faker\Generator as Faker;

class PayPeriodTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $name = 'Weekly';
        $this->create_type($name);

        $name = 'Monthly';
        $this->create_type($name);

        $name = 'Yearly';
        $this->create_type($name);

        $name = 'Custom';
        $this->create_type($name);
    }

    private function create_type($name)
    {
        $id = UUID::generate();
        PayPeriodType::create([
            'id' => $id,
            'name' => $name
        ]);
    }
}
