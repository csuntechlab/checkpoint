<?php

namespace App\Http\Controllers;

// Request
use App\Http\Requests\DisplayNameRequest;
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
        $organizationId = $user->getOrganizationIdAuthorizeAdmin();
        return $this->programUtility->all($organizationId);
    }

    public function create(DisplayNameRequest $request)
    {
        $user = Auth::user();
        $organizationId = $user->getOrganizationIdAuthorizeAdmin();
        return $this->programUtility->create($organizationId, $request['display_name']);
    }

    public function update(DisplayNameRequest $request, Program $program)
    {
        $user = Auth::user();
        $user->getOrganizationIdAuthorizeAdmin();
        $user->authorizeProgram($program);
        return $this->programUtility->update($program, $request['display_name']);
    }

    public function delete(Program $program)
    {
        $user = Auth::user();
        $user->getOrganizationIdAuthorizeAdmin();
        $user->authorizeProgram($program);
        return $this->programUtility->delete($program);
    }
}
