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
        $name = 'weekly';
        $display_name = 'Weekly';
        $this->create_type($name, $display_name);

        $name = 'monthly';
        $display_name = 'Monthly';
        $this->create_type($name, $display_name);

        $name = 'yearly';
        $display_name = 'Yearly';
        $this->create_type($name, $display_name);

        $name = 'custom';
        $display_name = 'Custom';
        $this->create_type($name, $display_name);
    }

    private function create_type($name, $display)
    {
        $id = UUID::generate();
        PayPeriodType::create([
            'id' => $id,
            'name' => $name,
            'display_name' => $display
        ]);
    }
}
