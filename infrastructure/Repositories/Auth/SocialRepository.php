<?php
namespace Infrastructure\Repositories\Auth;

use Domain\Entities\SocialUserAccountEntity;
use Domain\Entities\UserEntity;
use Infrastructure\Factories\UserFactory;
use Infrastructure\DataSources\Database\Users;
use Infrastructure\DataSources\Database\UsersNickName;
use Infrastructure\DataSources\Database\UsersStatus;
use Infrastructure\DataSources\Database\SocialAccounts;
use Infrastructure\Interfaces\Auth\SocialRepositoryInterface;
use Laravel\Socialite\Contracts\User as SocialUser;

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
    private $userFactory;

    /**
     * SocialRepository constructor.
     * @param SocialAccounts $socialAccounts
     * @param Users $users
     * @param UsersNickName $usersNickName
     * @param UsersStatus $usersStatus
     * @param UserFactory $userFactory
     */
    public function __construct(
        SocialAccounts      $socialAccounts,
        Users               $users,
        UsersNickName       $usersNickName,
        UsersStatus         $usersStatus,
        UserFactory         $userFactory
    ) {
        $this->socialAccounts      = $socialAccounts;
        $this->users               = $users;
        $this->usersNickName       = $usersNickName;
        $this->usersStatus         = $usersStatus;
        $this->userFactory         = $userFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function registerUser(SocialUser $socialUser): UserEntity
    {
        $userRecord = json_decode(json_encode($socialUser));
        $userEntity = $this->userFactory->createUser($userRecord);
        $userId     = $this->users->registerUser($userEntity);
        $userEntity->setId($userId);
        $this->usersNickName->registerNickName($userEntity);
        $this->usersStatus->registerActive($userEntity);

        return $userEntity;
    }

    /**
     * {@inheritdoc}
     */
    public function getSocialAccount(UserEntity $userEntity, string $driverName, SocialUser $socialUser): ?SocialUserAccountEntity
    {
        $result = $this->socialAccounts->getSocialAccount($socialUser, $driverName);
        if (is_null($result)) {
            return null;
        }
        $socialAccountRecord = (object) $result;

        return $this->userFactory->createSocialUserAccount($userEntity, $socialAccountRecord);
    }

    /**
     * {@inheritdoc}
     */
    public function syncAccount(UserEntity $userEntity, string $driverName, SocialUser $socialUser)
    {
        $registerSocialUserEntity = $this->userFactory->createSocialUser($userEntity, $driverName, $socialUser);
        $this->socialAccounts->registerSocialAccount($registerSocialUserEntity);
    }
}
