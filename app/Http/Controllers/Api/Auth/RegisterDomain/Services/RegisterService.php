<?php 
namespace App\Http\Controllers\Api\Auth\RegisterDomain\Services;

use App\User;
use Illuminate\Support\Facades\Hash;

use App\Http\Controllers\Api\Auth\RegisterDomain\Contracts\RegisterContract;
use App\DomainValueObjects\UUIDGenerator\UUID;


class RegisterService implements RegisterContract
{
    private $domainName = "user";

    public function register($request)
    {
        try {
            $name = (string)$request['name'];
            $email = (string)$request['email'];
            $password = (string)$request['password'];
        } catch (\Exception $e) {
            return ['message_error' => 'User was not successfully created.'];
        }

        $uuid = new UUID($this->domainName);

        try {
            $user = User::create([
                'id' => $uuid->toString,
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
                'user_profile' => 'place holder',
            ]);
        } catch (Illuminate\Database\QueryException $e) {
            return ['message_error' => 'User was not successfully created.'];
        }

        return $user;
    }
}
