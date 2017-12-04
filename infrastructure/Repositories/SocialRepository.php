<?php

namespace Infrastructure\Repositories;

use Domain\Entities\{
    RegisterUserEntity,
    SocialUserAccountEntity,
    RegisterSocialUserEntity,
    UserEntity
};
use Domain\ValueObjects\{
    SocialAccountValueObject,
    RegisterSocialUserValueObject,
    UserValueObject
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
    public function login(string $socialServiceName, SocialUser $socialUser): SocialUserAccountEntity
    {
        $userEntity = $this->findUser($socialUser);
        if (is_null($userEntity)) {
            $this->registerUser($socialUser);
        }

        $userId = $this->getUserId($socialUser);

        $socialUserAccountEntity = $this->findSocialAccount($userId, $socialServiceName, $socialUser);
        if (is_null($socialUserAccountEntity)) {
            $userId = $this->getUserId($socialUser);
            $this->associationSocialAccount($userId, $socialServiceName, $socialUser);
            $socialUserAccountEntity = $this->findSocialAccount($userId, $socialServiceName, $socialUser);
        }

        return $socialUserAccountEntity;
    }

    /**
     * @param SocialUser $socialUser
     * @return UserEntity|null
     */
    protected function findUser(SocialUser $socialUser): ?UserEntity
    {
        $result = $this->users->findUser($socialUser->getEmail());
        if (is_null($result)) {
            return null;
        }
        $userRecord = (object)$result;
        $userValueObject = new UserValueObject($userRecord);
        return new UserEntity($userRecord, $userValueObject);
    }

    /**
     * @param SocialUser $socialUser
     */
    protected function registerUser(SocialUser $socialUser)
    {
        $userInfo = new stdClass();
        $userInfo->name = $socialUser->getName();
        $userInfo->email = $socialUser->getEmail();
        $userValueObject = new UserValueObject($userInfo);
        $registerUserEntity = new RegisterUserEntity($userInfo, $userValueObject);
        $this->users->registerUser($registerUserEntity);
    }

    /**
     * @param SocialUser $socialUser
     * @return int|null
     */
    protected function getUserId(SocialUser $socialUser): ?int
    {
        return $this->users->getUserId($socialUser->getEmail());
    }

    /**
     * @param int $userId
     * @param string $socialServiceName
     * @param SocialUser $socialUser
     * @return SocialUserAccountEntity|null
     */
    protected function findSocialAccount(int $userId, string $socialServiceName, SocialUser $socialUser): ?SocialUserAccountEntity
    {
        $result = $this->socialAccounts->getSocialAccount($socialUser->getId(), $socialServiceName);
        if (is_null($result)) {
            return null;
        }
        $socialAccountRecord = (object)$result;
        $socialAccountValueObject = new SocialAccountValueObject($socialAccountRecord);
        return new SocialUserAccountEntity($userId, $socialAccountValueObject);
    }

    /**
     * @param int $userId
     * @param string $socialServiceName
     * @param SocialUser $socialUser
     */
    protected function associationSocialAccount(int $userId, string $socialServiceName, SocialUser $socialUser)
    {
        $registerSocialUserValueObject = new RegisterSocialUserValueObject($socialServiceName, $socialUser);
        $registerSocialUserEntity = new RegisterSocialUserEntity($userId, $registerSocialUserValueObject);
        $this->socialAccounts->registerSocialAccount($registerSocialUserEntity);
    }

}
