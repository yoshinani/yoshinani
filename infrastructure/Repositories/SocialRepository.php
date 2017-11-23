<?php

namespace Infrastructure\Repositories;

use Domain\Entities\RegisterUserEntity;
use Domain\Entities\SocialUserAccountEntity;
use Domain\Entities\RegisterSocialUserEntity;
use Domain\Entities\UserEntity;
use Domain\ValueObjects\SocialAccountValueObject;
use Domain\ValueObjects\RegisterSocialUserValueObject;
use Domain\ValueObjects\UserValueObject;
use Infrastructure\Interfaces\SocialRepositoryInterface;
use Infrastructure\DataSources\Database\SocialAccounts;
use Infrastructure\DataSources\Database\Users;
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
    public function findUser(SocialUser $socialUser)
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
     * {@inheritdoc}
     */
    public function getUserId(SocialUser $socialUser)
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
        $userValueObject = new UserValueObject($userInfo);
        $registerUserEntity = new RegisterUserEntity($userInfo, $userValueObject);
        $this->users->registerUser($registerUserEntity);
    }

    /**
     * {@inheritdoc}
     */
    public function findSocialAccount(int $userId, string $socialServiceName, SocialUser $socialUser)
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
     * {@inheritdoc}
     */
    public function associationSocialAccount(int $userId, string $socialServiceName, SocialUser $socialUser)
    {
        $registerSocialUserValueObject = new RegisterSocialUserValueObject($socialServiceName, $socialUser);
        $registerSocialUserEntity = new RegisterSocialUserEntity($userId, $registerSocialUserValueObject);
        $this->socialAccounts->registerSocialAccount($registerSocialUserEntity);
    }
}
