<?php
namespace Infrastructure\Interfaces\Auth;

use Domain\Entities\SocialUserAccountEntity;
use Domain\Entities\UserEntity;
use Laravel\Socialite\Contracts\User as SocialUser;

/**
 * Interface SocialRepositoryInterface
 * @package Infrastructure\Interfaces\Auth
 */
interface SocialRepositoryInterface
{
    /**
     * @param SocialUser $socialUser
     * @return UserEntity
     */
    public function registerUser(SocialUser $socialUser): UserEntity;

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
