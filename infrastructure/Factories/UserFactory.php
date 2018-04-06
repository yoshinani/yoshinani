<?php
namespace Infrastructure\Factories;

use Domain\Entities\RegisterUserEntity;
use Domain\Entities\RegisterUserNickNameEntity;
use Domain\Entities\RegisterUserPasswordEntity;
use Domain\Entities\SocialUserAccountEntity;
use Domain\Entities\UserDetailEntity;
use Domain\Entities\UserEntity;
use Domain\Entities\UserPasswordEntity;
use Laravel\Socialite\Contracts\User as SocialUser;
use Domain\Entities\RegisterSocialUserEntity;
use stdClass;

class UserFactory
{
    /**
     * @param stdClass $userRecord
     * @return UserEntity
     */
    public function createUser(stdClass $userRecord)
    {
        return new UserEntity($userRecord);
    }

    /**
     * @param int $userId
     * @param stdClass $userPasswordRecord
     * @return UserPasswordEntity
     */
    public function createUserPassword(int $userId, stdClass $userPasswordRecord): UserPasswordEntity
    {
        return new UserPasswordEntity($userId, $userPasswordRecord);
    }

    /**
     * @param stdClass $userDetail
     * @return UserDetailEntity
     */
    public function createUserDetail(stdClass $userDetail): UserDetailEntity
    {
        return new UserDetailEntity($userDetail);
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
     * @param stdClass $socialAccountRecord
     * @return SocialUserAccountEntity
     */
    public function createSocialUserAccount(int $userId, stdClass $socialAccountRecord): SocialUserAccountEntity
    {
        return new SocialUserAccountEntity($userId, $socialAccountRecord);
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