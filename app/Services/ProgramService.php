<?php
namespace App\Services;

use \Illuminate\Support\Facades\DB;

// Domain Value Objects
use App\DomainValueObjects\UUIDGenerator\UUID;

//Models
use App\Models\Project;

//Exceptions

//Contracts
use App\Contracts\ProgramContract;
use Illuminate\Database\QueryException;
use App\Exceptions\ProgramExceptions\DuplicateProgramName;

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

        $projectId = UUID::generate();

        try {
            $project = Project::create([
                'id' => $projectId,
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

        return $project;
    }

    public function allWithLocation($organizationId)
    {
        try {
            return Project::with('location')->where('organization_id', $organizationId)->get();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function all($organizationId)
    {
        try {
            return Project::where('organization_id', $organizationId)->get();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function update(Project $program, $displayName)
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

    public function delete(Project $program)
    {
        try {
            $program->delete();
        } catch (\Exception $e) {
            throw $e;
        }
        return ['message' => 'Program was deleted.'];
    }
}
