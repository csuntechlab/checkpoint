<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// Auth
use Illuminate\Support\Facades\Auth;

// Contracts
use App\Contracts\ProgramContract;
use App\Models\Project;
use App\Http\Requests\ProgramRequest;

class ProgramController extends Controller
{
    private $programUtility;
    public function __construct(ProgramContract $programContract)
    {
        $this->programUtility = $programContract;
    }

    public function all()
    {
        $user = Auth::user();
        $organizationId = $user->organization_id;
        return $this->programUtility->all($organizationId);
    }

    public function create(ProgramRequest $request)
    {
        $user = Auth::user();
        $organizationId = $user->organization_id;
        return $this->programUtility->create($organizationId, $request['display_name']);
    }

    public function update(ProgramRequest $request, Project $program)
    {
        return $this->programUtility->update($program, $request['display_name']);
    }

    public function delete(Project $program)
    {
        return $this->programUtility->delete($program);
    }
}
