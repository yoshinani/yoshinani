<?php

namespace Infrastructure\Repositories;

use Domain\Entities\{
    RegisterUserEntity,
    SocialUserAccountEntity,
    RegisterSocialUserEntity
};
use Infrastructure\DataSources\Database\{
    Users,
    UsersStatus,
    SocialAccounts
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
    private $usersStatus;

    /**
     * SocialRepository constructor.
     * @param SocialAccounts $socialAccounts
     * @param Users $users
     * @param UsersStatus $usersStatus
     */
    public function __construct(
        SocialAccounts $socialAccounts,
        Users          $users,
        UsersStatus    $usersStatus
    ) {
        $this->socialAccounts = $socialAccounts;
        $this->users = $users;
        $this->usersStatus = $usersStatus;
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
        $userId = $this->users->registerUser($registerUserEntity);
        $this->usersStatus->registerActive($userId, $registerUserEntity);
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
