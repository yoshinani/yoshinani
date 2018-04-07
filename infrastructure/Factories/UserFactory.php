<?php
namespace Infrastructure\Factories;

use stdClass;
use Domain\Entities\UserEntity;
use Domain\Entities\UserDetailEntity;
use Domain\Entities\UserPasswordEntity;
use Domain\Entities\SocialUserAccountEntity;

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
     * @param stdClass $userDetail
     * @return UserDetailEntity
     */
    public function createUserDetail(stdClass $userDetail): UserDetailEntity
    {
        return new UserDetailEntity($userDetail);
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
     * @param int $userId
     * @param stdClass $socialAccountRecord
     * @return SocialUserAccountEntity
     */
    public function createSocialUserAccount(int $userId, stdClass $socialAccountRecord): SocialUserAccountEntity
    {
        return new SocialUserAccountEntity($userId, $socialAccountRecord);
    }
}
