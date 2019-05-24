<?php
namespace App\Services;

use \Illuminate\Support\Facades\DB;

// Domain Value Objects
use App\DomainValueObjects\UUIDGenerator\UUID;

//Models
use App\Models\Program;
use App\User;
use App\Models\UserProgram;

//Exceptions
use Illuminate\Database\QueryException;

//Contracts
use App\Contracts\ProgramContract;
use App\Exceptions\ProgramExceptions\DuplicateProgramName;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProgramService implements ProgramContract
{
    private function generateName($displayName)
    {
        $name = preg_replace("/[^a-z0-9_]+/i", "", $displayName);
        return strtolower($name);
    }

    public function create($organizationId, $displayName)
    {
        $name = $this->generateName($displayName);

        $programId = UUID::generate();

        try {
            $program = Program::create([
                'id' => $programId,
                'organization_id' => $organizationId,
                'name' => $name,
                'display_name' => $displayName,
            ]);
        } catch (\Exception $e) {
            if ($e instanceof QueryException) { // Handles duplicate
                throw new DuplicateProgramName($displayName);
            }
            throw $e;
        }

        return $program;
    }

    public function allWithLocation($organizationId)
    {
        try {
            return Program::with('location')->where('organization_id', $organizationId)->get();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function allWithUsers($organizationId)
    {
        try {
            return Program::with('users.role')->where('organization_id', $organizationId)->get();
        } catch (\Exception $e) {
            throw $e;
        }
    }


    public function all($organizationId)
    {
        try {
            return Program::where('organization_id', $organizationId)->get();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function update(Program $program, $displayName)
    {
        $name = $this->generateName($displayName);

        return DB::transaction(function () use ($program, $displayName, $name) {
            try {
                $program->display_name = $displayName;
                $program->name = $name;
                $program->save();
            } catch (\Exception $e) {
                if ($e instanceof QueryException) { // Handles duplicate
                    throw new DuplicateProgramName($displayName);
                }
                throw $e;
            }
            return $program;
        });
    }

    public function delete(Program $program)
    {
        try {
            $program->delete();
        } catch (\Exception $e) {
            throw $e;
        }
        return ['message' => 'Program was deleted.'];
    }

    public function removeUser(User $user, Program $program)
    {
        try {
            $userProgram = UserProgram::where('user_id', $user->id)->where('program_id', $program->id)->firstOrFail();
            $userProgram->delete();
        } catch (\Exception $e) {
            throw $e;
        }
        return ['message' => 'User was deleted from ' . $program->display_name . '.'];
    }

    public function addUser($user, $program)
    {
        try {
            UserProgram::create([
                'id' => UUID::generate(),
                'user_id' => $user->id,
                'program_id' => $program->id,
            ]);
        } catch (\Exception $e) {
            throw $e;
        }

        return ['message' => 'User was added to ' . $program->display_name . '.'];
    }
}
