<?php
namespace Infrastructure\Factories;

use Domain\Entities\SocialUserAccountEntity;
use Domain\Entities\UserEntity;
use Illuminate\Support\Collection;

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
