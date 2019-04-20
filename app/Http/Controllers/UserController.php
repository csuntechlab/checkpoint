<?php
declare (strict_types = 1);
namespace App\Http\Controllers;

// Auth
use Illuminate\Support\Facades\Auth;


// Contracts
use App\Contracts\UserContract;

class UserController extends Controller
{

    protected $userUtility;

    public function __construct(UserContract $userContract)
    {
        $this->userUtility = $userContract;
    }

    public function profile()
    {
        $user = Auth::user();
        $userId = $user->id;
        return $this->userUtility->profile($userId);
    }
}
