<?php
namespace Infrastructure\Factories;

use Illuminate\Support\Collection;
use Domain\Entities\UserEntity;
use Domain\Entities\SocialUserAccountEntity;

class SocialAccountFactory
{
    /**
     * @param UserEntity $userEntity
     * @param Collection $accountCollection
     * @return SocialUserAccountEntity
     */
    public function createSocialUserAccount(UserEntity $userEntity, Collection $accountCollection): SocialUserAccountEntity
    {
        return new SocialUserAccountEntity($userEntity, $accountCollection);
    }
}
