<?php
namespace App\Services;

// Domain Value Objects
use App\DomainValueObjects\UUIDGenerator\UUID;

//Models

//Exceptions

//Contracts
use App\Contracts\ProgramContract;

class ProgramService implements ProgramContract
{
    public function create($organizationId, $name)
    {
        dd("Create");
    }

    public function all($organizationId)
    {
        dd("All");
    }

    public function update($programId)
    {
        dd("update");
    }

    public function delete($programId)
    {
        dd("delete");
    }
}
