<?php

use Illuminate\Database\Seeder;

use Faker\Generator as Faker;
use App\DomainValueObjects\UUIDGenerator\UUID;


use App\User;
use App\Models\Program;
use App\Models\UserProgram;
use App\Models\Organization;

class ProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i = 0; $i < 30; $i++) {
            $programId = UUID::generate();
            $organizationId = Organization::all()->random()->id;

            $program = $this->createProgram($programId, $organizationId, $faker);

            $users = User::where('organization_id', $organizationId)->get();

            $users = $users->shuffle();
            $users = $users->all();

            foreach ($users as $user) {
                $this->assignUsersToPrograms($user, $program);
            }
        }
    }

    private function assignUsersToPrograms($user, $program)
    {
        UserProgram::create([
            'id' => UUID::generate(),
            'user_id' => $user->id,
            'program_id' => $program->id
        ]);
    }

    private function createProgram($programId, $organizationId, Faker $faker)
    {
        $name = $faker->unique()->name;
        $program = Program::create([
            'id' => $programId,
            'organization_id' => $organizationId,
            'name' => $name,
            'display_name' => $name
        ]);

        return $program;
    }
}
