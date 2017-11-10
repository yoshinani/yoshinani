<?php

namespace Infrastructure\Interfaces;

use Domain\ValueObjects\UserValueObject;
use Laravel\Socialite\Contracts\User as SocialUser;

interface SocialRepositoryInterface
{
    public function findSocialAccount(string $socialServiceName, SocialUser $socialUser);
    public function findUser(SocialUser $socialUser);
    public function getUserId(SocialUser $socialUser);
    public function registerUser(SocialUser $socialUser);
    public function associationSocialAccount(int $userId, string $socialServiceName, SocialUser $socialUser, UserValueObject $userValueObject);
}