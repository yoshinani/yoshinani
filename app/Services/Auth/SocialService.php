<?php

namespace App\Services\Auth;

use Exception;
use Laravel\Socialite\Contracts\User as SocialUser;

/**
 * Class SocialService
 * @package App\Services\Auth
 */
class SocialService
{
    /**
     * @param SocialUser $socialUser
     * @throws Exception
     */
    public function existsItems(SocialUser $socialUser)
    {
        if (is_null($socialUser->getName()) || is_null($socialUser->getEmail())) {
            throw new Exception('Name or email is missing');
        }
    }

}
