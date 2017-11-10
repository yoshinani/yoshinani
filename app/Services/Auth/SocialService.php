<?php

namespace App\Services\Auth;

use Auth;
use Domain\Entities\SocialUserAccountEntity;
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

    /**
     * @param string $socialServiceName
     * @param SocialUser $socialUser
     * @param SocialUserAccountEntity $socialUserAccountEntity
     * @throws Exception
     */
    public function socialLogin(string $socialServiceName, SocialUser $socialUser, SocialUserAccountEntity $socialUserAccountEntity)
    {
        $socialUserAccount = $socialUserAccountEntity->toArray();

        if (!$socialUserAccount['socialServiceName'] === $socialServiceName) {
            throw new Exception('Authentication drivers do not match');
        }

        if (!$socialUserAccount['socialUserId'] === $socialUser->getId()) {
            throw new Exception('It does not match the ID of SNSAccount');
        }

        if (!Auth::loginUsingId($socialUserAccount['id'])) {
            throw new Exception('It is a User that does not exist');
        }
    }
}