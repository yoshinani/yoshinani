<?php
namespace Infrastructure\Repositories\Auth;

use Domain\Entities\SocialUserAccountEntity;
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
        SocialAccounts $socialAccounts,
        Users          $users,
        UsersNickName  $usersNickName,
        UsersStatus    $usersStatus,
        UserFactory    $userFactory
    ) {
        $this->socialAccounts = $socialAccounts;
        $this->users          = $users;
        $this->usersNickName  = $usersNickName;
        $this->usersStatus    = $usersStatus;
        $this->userFactory    = $userFactory;
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
        $userRecord                 = json_decode(json_encode($socialUser));
        $registerUserEntity         = $this->userFactory->createRegisterUser($userRecord);
        $userId                     = $this->users->registerUser($registerUserEntity);
        $registerUserNickNameEntity = $this->userFactory->createRegisterUserNickName($userId, $userRecord);
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
        $socialAccountRecord = (object) $result;

        return $this->userFactory->createSocialUserAccount($userId, $socialAccountRecord);
    }

    /**
     * {@inheritdoc}
     */
    public function synchronizeSocialAccount(int $userId, string $driverName, SocialUser $socialUser)
    {
        $registerSocialUserEntity = $this->userFactory->createRegisterSocialUser($userId, $driverName, $socialUser);
        $this->socialAccounts->registerSocialAccount($registerSocialUserEntity);
    }
}
