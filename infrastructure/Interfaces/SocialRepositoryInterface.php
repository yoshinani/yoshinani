<?php

namespace Infrastructure\Interfaces;

use Domain\ValueObjects\UserValueObject;
use Laravel\Socialite\Contracts\User as SocialUser;

/**
 * Interface SocialRepositoryInterface
 * @package Infrastructure\Interfaces
 */
interface SocialRepositoryInterface
{
    /**
     * @param int $userId
     * @param string $socialServiceName
     * @param SocialUser $socialUser
     * @return mixed
     */
    public function findSocialAccount(int $userId, string $socialServiceName, SocialUser $socialUser);

    /**
     * @param SocialUser $socialUser
     * @return mixed
     */
    public function findUser(SocialUser $socialUser);

    /**
     * @param SocialUser $socialUser
     * @return mixed
     */
    public function getUserId(SocialUser $socialUser);

    /**
     * @param SocialUser $socialUser
     * @return mixed
     */
    public function registerUser(SocialUser $socialUser);

    /**
     * @param int $userId
     * @param string $socialServiceName
     * @param SocialUser $socialUser
     * @return mixed
     */
    public function associationSocialAccount(int $userId, string $socialServiceName, SocialUser $socialUser);
}
