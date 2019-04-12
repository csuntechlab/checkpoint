<?php

use Illuminate\Database\Seeder;

use App\Models\TimeCalculatorType;
use App\DomainValueObjects\UUIDGenerator\UUID;

class TimeCalculatorTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $name = 'meta+lab';
        $display_name = 'META+LAB';
        $this->create_type($name, $display_name);

        $name = 'build_poder';
        $display_name = 'Builde Poder';
        $this->create_type($name, $display_name);
    }

    private function create_type($name, $display)
    {
        $id = UUID::generate();
        TimeCalculatorType::create([
            'id' => $id,
            'name' => $name,
            'display_name' => $display
        ]);
    }
}
