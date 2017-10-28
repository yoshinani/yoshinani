<?php

namespace Domain\Services\Auth;

use DB;
use Laravel\Socialite\Contracts\User;

class AuthService
{
    public function findUser(User $providerUser)
    {
        $result = DB::table('users')
            ->where('email', $providerUser->getEmail())
            ->first();

        return $result;
    }

    public function registerUser(User $providerUser)
    {
        DB::table('users')->insert(
            [
                'email' => $providerUser->getEmail(),
                'name' => $providerUser->getName(),
            ]
        );
    }
}