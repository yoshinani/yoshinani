<?php
namespace Infrastructure\Factories;

use stdClass;
use Domain\Entities\RegisterUserEntity;
use Domain\Entities\RegisterSocialUserEntity;
use Domain\Entities\RegisterUserNickNameEntity;
use Domain\Entities\RegisterUserPasswordEntity;
use Laravel\Socialite\Contracts\User as SocialUser;

class RegisterUserFactory
{
    /**
     * @param stdClass $userRecord
     * @return RegisterUserEntity
     */
    public function createRegisterUser(stdClass $userRecord): RegisterUserEntity
    {
        return new RegisterUserEntity($userRecord);
    }

    /**
     * @param int $userId
     * @param stdClass $userRecord
     * @return RegisterUserNickNameEntity
     */
    public function createRegisterUserNickName(int $userId, stdClass $userRecord): RegisterUserNickNameEntity
    {
        return new RegisterUserNickNameEntity($userId, $userRecord);
    }

    /**
     * @param int $userId
     * @param stdClass $userRecord
     * @return RegisterUserPasswordEntity
     */
    public function createRegisterUserPassword(int $userId, stdClass $userRecord): RegisterUserPasswordEntity
    {
        return new RegisterUserPasswordEntity($userId, $userRecord);
    }

    /**
     * @param int $userId
     * @param string $driverName
     * @param SocialUser $socialUser
     * @return RegisterSocialUserEntity
     */
    public function createRegisterSocialUser(int $userId, string $driverName, SocialUser $socialUser): RegisterSocialUserEntity
    {
        return new RegisterSocialUserEntity($userId, $driverName, $socialUser);
    }
}
