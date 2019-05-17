<?php

namespace App\Http\Controllers;

// Request
use App\Http\Requests\ProgramRequest;
// Auth
use Illuminate\Support\Facades\Auth;
// Models
use App\Models\Program;
// Contracts
use App\Contracts\ProgramContract;

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

    public function update(ProgramRequest $request, Program $program)
    {
        return $this->programUtility->update($program, $request['display_name']);
    }

    public function delete(Program $program)
    {
        return $this->programUtility->delete($program);
    }
}