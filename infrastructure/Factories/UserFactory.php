<?php
namespace Infrastructure\Factories;

use Domain\Entities\SocialUserEntity;
use Domain\Entities\UserEntity;
use Laravel\Socialite\Contracts\User as SocialUser;
use stdClass;

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
     * @param UserEntity $userEntity
     * @param string $driverName
     * @param SocialUser $socialUser
     * @return SocialUserEntity
     */
    public function createSocialUser(UserEntity $userEntity, string $driverName, SocialUser $socialUser): SocialUserEntity
    {
        return new SocialUserEntity($userEntity, $driverName, $socialUser);
    }
}
