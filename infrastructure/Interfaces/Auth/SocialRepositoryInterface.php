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
     * @param UserEntity $userEntity
     * @return SocialUserAccountEntity
     */
    public function getSocialAccount(UserEntity $userEntity): SocialUserAccountEntity;

    /**
     * @param UserEntity $userEntity
     * @param string $driverName
     * @param SocialUser $socialUser
     */
    public function syncAccount(UserEntity $userEntity, string $driverName, SocialUser $socialUser);
}
