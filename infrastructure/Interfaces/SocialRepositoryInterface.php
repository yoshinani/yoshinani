<?php

namespace Infrastructure\Interfaces;

use Domain\Entities\SocialUserAccountEntity;
use Domain\Entities\UserEntity;
use Laravel\Socialite\Contracts\User as SocialUser;

/**
 * Interface SocialRepositoryInterface
 * @package Infrastructure\Interfaces
 */
interface SocialRepositoryInterface
{
    /**
     * @param SocialUser $socialUser
     * @return int|null
     */
    public function getUserId(SocialUser $socialUser): ?int;

    /**
     * @param SocialUser $socialUser
     */
    public function registerUser(SocialUser $socialUser);

    /**
     * @param int $userId
     * @param string $socialServiceName
     * @param SocialUser $socialUser
     * @return SocialUserAccountEntity|null
     */
    public function findSocialAccount(int $userId, string $socialServiceName, SocialUser $socialUser): ?SocialUserAccountEntity;

    /**
     * @param int $userId
     * @param string $socialServiceName
     * @param SocialUser $socialUser
     */
    public function synchronizeSocialAccount(int $userId, string $socialServiceName, SocialUser $socialUser);
}
