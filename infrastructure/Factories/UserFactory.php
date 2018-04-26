<?php
namespace Infrastructure\Factories;

use stdClass;
use Domain\Entities\UserEntity;
use Domain\Entities\SocialUserEntity;
use Domain\Entities\SocialUserAccountEntity;
use Laravel\Socialite\Contracts\User as SocialUser;

class UserFactory
{
    /**
     * @param stdClass $userRecord
     * @return UserEntity
     */
    public function createUser(stdClass $userRecord): UserEntity
    {
        $userEntity = new UserEntity($userRecord);

        if (property_exists($userRecord, 'id')) {
            $userEntity->setId($userRecord->id);
        }
        if (property_exists($userRecord, 'password')) {
            $userEntity->setPassword($userRecord);
        }

        return $userEntity;
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

    /**
     * @param UserEntity $userEntity
     * @param stdClass $socialAccountRecord
     * @return SocialUserAccountEntity
     */
    public function createSocialUserAccount(UserEntity $userEntity, stdClass $socialAccountRecord): SocialUserAccountEntity
    {
        return new SocialUserAccountEntity($userEntity->getId(), $socialAccountRecord);
    }
}
