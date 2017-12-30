<?php

namespace Infrastructure\Repositories;

use Domain\Entities\{
    RegisterUserEntity,
    SocialUserAccountEntity,
    RegisterSocialUserEntity,
    UserEntity
};
use Infrastructure\DataSources\Database\{
    SocialAccounts,
    Users
};
use Infrastructure\Interfaces\SocialRepositoryInterface;
use Laravel\Socialite\Contracts\User as SocialUser;
use stdClass;

/**
 * Class SocialRepository
 * @package Infrastructure\Repositories
 */
class SocialRepository implements SocialRepositoryInterface
{
    private $socialAccounts;
    private $users;

    /**
     * SocialRepository constructor.
     * @param SocialAccounts $socialAccounts
     * @param Users $users
     */
    public function __construct(
        SocialAccounts $socialAccounts,
        Users          $users
    ) {
        $this->socialAccounts = $socialAccounts;
        $this->users = $users;
    }

    /**
     * {@inheritdoc}
     */
    public function getUserId(SocialUser $socialUser): ?int
    {
        return $this->users->getUserId($socialUser->getEmail());
    }

    /**
     * {@inheritdoc}
     */
    public function registerUser(SocialUser $socialUser)
    {
        $userInfo = new stdClass();
        $userInfo->name = $socialUser->getName();
        $userInfo->email = $socialUser->getEmail();
        $registerUserEntity = new RegisterUserEntity($userInfo);
        $this->users->registerUser($registerUserEntity);
    }

    /**
     * {@inheritdoc}
     */
    public function findSocialAccount(int $userId, string $socialServiceName, SocialUser $socialUser): ?SocialUserAccountEntity
    {
        $result = $this->socialAccounts->getSocialAccount($socialUser->getId(), $socialServiceName);
        if (is_null($result)) {
            return null;
        }
        $socialAccountRecord = (object)$result;
        return new SocialUserAccountEntity($userId, $socialAccountRecord);
    }

    /**
     * {@inheritdoc}
     */
    public function synchronizeSocialAccount(int $userId, string $socialServiceName, SocialUser $socialUser)
    {
        $registerSocialUserEntity = new RegisterSocialUserEntity($userId, $socialServiceName, $socialUser);
        $this->socialAccounts->registerSocialAccount($registerSocialUserEntity);
    }
}
