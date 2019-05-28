<?php
namespace App\Services;

use \Illuminate\Support\Facades\DB;

// Domain Value Objects
use App\DomainValueObjects\UUIDGenerator\UUID;

//Models
use App\Models\Program;

//Exceptions
use App\Exceptions\DuplicateName;
use Illuminate\Database\QueryException;

//Contracts
use App\Contracts\ProgramContract;


class ProgramService implements ProgramContract
{
    public function generateName($displayName)
    {
        $name = preg_replace("/[^a-z0-9_]+/i", "", $displayName);
        return strtolower($name);
    }

    public function create($organizationId, $displayName)
    {
        $name = $this->generateName($displayName);

        $programId = UUID::generate();

        try {
            return Program::create([
                'id' => $programId,
                'organization_id' => $organizationId,
                'name' => $name,
                'display_name' => $displayName,
            ]);
        } catch (\Exception $e) {
            if ($e instanceof QueryException) { // Handles duplicate
                throw new DuplicateName($displayName);
            }
            throw $e;
        }
    }

    public function allWithLocation($organizationId)
    {
        try {
            return Program::with('location')->where('organization_id', $organizationId)->get();
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
                    throw new DuplicateName($displayName);
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
}
