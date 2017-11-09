<?php

namespace Infrastructure\Interfaces;

use Domain\ValueObjects\UserValueObject;
use Laravel\Socialite\Contracts\User as SocialUser;

interface SocialRepositoryInterface
{
    public function findSocialAccount(SocialUser $socialUser, $provider);
    public function findUser(SocialUser $socialUser);
    public function getUserId(SocialUser $socialUser);
    public function registerUser(SocialUser $socialUser);
    public function associationSocialAccount(SocialUser $socialUser, $provider, UserValueObject $userValueObject, int $userId);
}