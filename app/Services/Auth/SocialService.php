<?php

namespace App\Services\Auth;

use Auth;
use Domain\Entities\SocialUserAccountEntity;
use Domain\ValueObjects\SocialAccountValueObject;
use Domain\ValueObjects\UserValueObject;
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

    public function socialLogin(SocialUserAccountEntity $socialUserAccountEntity, User $providerUser, string $provider)
    {
        $socialUserAccount = $socialUserAccountEntity->toArray();

        if (!$socialUserAccount['providerName'] === $provider) {
            throw new Exception('Authentication drivers do not match');
        }

        if (!$socialUserAccount['providerUserId'] === $providerUser->getId()) {
            throw new Exception('It does not match the ID of SNSAccount');
        }

        if (!Auth::loginUsingId($socialUserAccount['id'])) {
            throw new Exception('It is a User that does not exist');
        }
    }
}