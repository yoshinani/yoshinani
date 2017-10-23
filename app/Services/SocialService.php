<?php

namespace App\Services;

use DB;
use Auth;
use Exception;
use Laravel\Socialite\Contracts\User;

class SocialService
{
    public function existsItems(User $providerUser)
    {
        if (is_null($providerUser->getName()) || is_null($providerUser->getEmail())) {
            throw new Exception('Name or email is missing');
        }
        return true;
    }

    public function findUser(User $providerUser)
    {
        $result = DB::table('users')
            ->where('email', $providerUser->getEmail())
            ->first();

        return $result;
    }

    public function findSocialAccount(User $providerUser, $provider)
    {
        $result = DB::table('social_accounts')
            ->where('provider_name', $provider)
            ->where('provider_id', $providerUser->getId())
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

    public function associationSocialAccount(User $providerUser, $provider, $user)
    {
        DB::table('social_accounts')->insert(
            [
                'user_id'       => $user->id,
                'provider_id'   => $providerUser->getId(),
                'provider_name' => $provider,
            ]
        );
    }

    public function socialLogin($user)
    {
        $auth = Auth::loginUsingId($user->id);
        if (!$auth) {
            throw new Exception('It is a User that does not exist');
        }
    }
}