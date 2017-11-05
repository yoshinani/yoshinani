<?php

namespace App\Services\Auth;

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

    public function socialLogin($userId)
    {
        if (!Auth::loginUsingId($userId)) {
            throw new Exception('It is a User that does not exist');
        }
    }
}