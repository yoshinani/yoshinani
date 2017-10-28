<?php

namespace Infrastructure\Repositories;

use DB;

class AuthRepository implements AuthRepositoryInterface
{

    public function findUser($providerUserEmail)
    {
        $result = DB::table('users')
            ->where('email', $providerUserEmail)
            ->first();

        return $result;
    }

    public function registerUser($providerUserEmail, $providerUserName)
    {
        DB::table('users')->insert(
            [
                'email' => $providerUserEmail,
                'name'  => $providerUserName,
            ]
        );
    }
}