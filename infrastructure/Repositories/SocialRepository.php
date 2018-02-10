<?php

namespace Infrastructure\Repositories;

use Domain\Entities\{
    RegisterUserEntity, RegisterUserNickNameEntity, SocialUserAccountEntity, RegisterSocialUserEntity
};
use Infrastructure\DataSources\Database\{
    Users, UsersNickName, UsersStatus, SocialAccounts
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
    private $usersNickName;
    private $usersStatus;

    /**
     * SocialRepository constructor.
     * @param SocialAccounts $socialAccounts
     * @param Users $users
     * @param UsersNickName $usersNickName
     * @param UsersStatus $usersStatus
     */
    public function __construct(
        SocialAccounts $socialAccounts,
        Users          $users,
        UsersNickName  $usersNickName,
        UsersStatus    $usersStatus
    ) {
        $this->socialAccounts = $socialAccounts;
        $this->users = $users;
        $this->usersNickName = $usersNickName;
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
    public function registerUser(stdClass $userRecord)
    {
        $registerUserEntity = new RegisterUserEntity($userRecord);
        $userId = $this->users->registerUser($registerUserEntity);
        $registerUserNickNameEntity = new RegisterUserNickNameEntity($userId, $userRecord);
        $this->usersNickName->registerNickName($userId, $registerUserNickNameEntity);
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
