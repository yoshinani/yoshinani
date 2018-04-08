<?php
namespace Infrastructure\Factories;

use stdClass;
use Domain\Entities\Registers\UserEntity;
use Domain\Entities\Registers\SocialUserEntity;
use Domain\Entities\Registers\UserNickNameEntity;
use Domain\Entities\Registers\UserPasswordEntity;
use Laravel\Socialite\Contracts\User as SocialUser;

class RegisterUserFactory
{
    /**
     * @param stdClass $userRecord
     * @return UserEntity
     */
    public function createUser(stdClass $userRecord): UserEntity
    {
        return new UserEntity($userRecord);
    }

    /**
     * @param int $userId
     * @param stdClass $userRecord
     * @return UserNickNameEntity
     */
    public function createNickName(int $userId, stdClass $userRecord): UserNickNameEntity
    {
        return new UserNickNameEntity($userId, $userRecord);
    }

    /**
     * @param int $userId
     * @param stdClass $userRecord
     * @return UserPasswordEntity
     */
    public function createPassword(int $userId, stdClass $userRecord): UserPasswordEntity
    {
        return new UserPasswordEntity($userId, $userRecord);
    }

    /**
     * @param int $userId
     * @param string $driverName
     * @param SocialUser $socialUser
     * @return SocialUserEntity
     */
    public function createSocialUser(int $userId, string $driverName, SocialUser $socialUser): SocialUserEntity
    {
        return new SocialUserEntity($userId, $driverName, $socialUser);
    }
}
