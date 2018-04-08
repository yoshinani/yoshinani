<?php
namespace Infrastructure\Factories;

use Domain\Entities\Registers\SocialUserEntity;
use Laravel\Socialite\Contracts\User as SocialUser;

class RegisterUserFactory
{
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
