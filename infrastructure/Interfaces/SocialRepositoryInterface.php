<?php

namespace Infrastructure\Interfaces;

use Domain\Entities\SocialUserAccountEntity;
use Domain\Entities\UserEntity;
use Laravel\Socialite\Contracts\User as SocialUser;
use stdClass;

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
     * @param stdClass $userRecord
     */
    public function registerUser(stdClass $userRecord);

    /**
     * @param int $userId
     * @param string $driverName
     * @param SocialUser $socialUser
     * @return SocialUserAccountEntity|null
     */
    public function findSocialAccount(int $userId, string $driverName, SocialUser $socialUser): ?SocialUserAccountEntity;

    /**
     * @param int $userId
     * @param string $driverName
     * @param SocialUser $socialUser
     */
    public function synchronizeSocialAccount(int $userId, string $driverName, SocialUser $socialUser);
}
