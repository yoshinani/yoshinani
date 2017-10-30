<?php

namespace Domain\Services\Auth;

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

    public function socialLogin($user)
    {
        $auth = Auth::loginUsingId($user->id);
        if (!$auth) {
            throw new Exception('It is a User that does not exist');
        }
    }
}