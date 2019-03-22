<?php 
namespace App\Http\Controllers\Api\Auth\LoginDomain\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

use App\User;

use App\Exceptions\AuthExceptions\UnauthenticatedUser;

use App\Http\Controllers\Api\Auth\LoginDomain\Contracts\LoginContract;

class LoginService implements LoginContract
{
    private function authenticateUser($request): User
    {
        $credentials = request(['email', 'password']);

        if (!Auth::attempt($credentials))
            throw new UnauthenticatedUser();

        return $request->user();
    }

    private function createToken($user, $request): array
    {
        $tokenResult = $user->createToken('checkpoint');

        $token = $tokenResult->token;

        if ($request->rememberMe)
            $token->expires_at = Carbon::now()->addWeeks(1);

        $token->save();

        return [
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ];
    }


    public function login($request): array
    {
        $user = $this->authenticateUser($request);
        return $this->createToken($user, $request);
    }
}
