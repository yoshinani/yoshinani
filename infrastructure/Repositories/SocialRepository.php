<?php

namespace Infrastructure\Repositories;

use Domain\Entities\{
    RegisterUserEntity,
    SocialUserAccountEntity,
    RegisterSocialUserEntity
};
use Infrastructure\DataSources\Database\{
    Users, UsersName, UsersStatus, SocialAccounts
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
    private $usersName;
    private $usersStatus;

    /**
     * SocialRepository constructor.
     * @param SocialAccounts $socialAccounts
     * @param Users $users
     * @param UsersName $usersName
     * @param UsersStatus $usersStatus
     */
    public function __construct(
        SocialAccounts $socialAccounts,
        Users          $users,
        UsersName      $usersName,
        UsersStatus    $usersStatus
    ) {
        $this->socialAccounts = $socialAccounts;
        $this->users = $users;
        $this->usersName = $usersName;
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
        $userInfo->nickName = $socialUser->getNickname();
        $userInfo->name = $socialUser->getName();
        $userInfo->email = $socialUser->getEmail();
        $registerUserEntity = new RegisterUserEntity($userInfo);
        $userId = $this->users->registerUser($registerUserEntity);
        $this->usersName->registerUserName($userId, $registerUserEntity);
        $this->usersStatus->registerActive($userId, $registerUserEntity);
    }

    /**
     * {@inheritdoc}
     */
    public function findSocialAccount(int $userId, string $driverName, SocialUser $socialUser): ?SocialUserAccountEntity
    {
        $result = $this->socialAccounts->getSocialAccount($socialUser->getId(), $driverName);
        if (is_null($result)) {
            return null;
        }
        $socialAccountRecord = (object)$result;
        return new SocialUserAccountEntity($userId, $socialAccountRecord);
    }

    /**
     * {@inheritdoc}
     */
    public function synchronizeSocialAccount(int $userId, string $driverName, SocialUser $socialUser)
    {
        $registerSocialUserEntity = new RegisterSocialUserEntity($userId, $driverName, $socialUser);
        $this->socialAccounts->registerSocialAccount($registerSocialUserEntity);
    }
}
