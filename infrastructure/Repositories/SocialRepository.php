<?php

namespace Infrastructure\Repositories;

use Domain\Entities\SocialUserEntity;
use Domain\Entities\UserEntity;
use Domain\ValueObjects\SocialAccountValueObject;
use Domain\ValueObjects\SocialUserValueObject;
use Domain\ValueObjects\UserValueObject;
use Infrastructure\Interfaces\SocialRepositoryInterface;
use Infrastructure\DataSources\Database\SocialAccounts;
use Infrastructure\DataSources\Database\Users;
use Laravel\Socialite\Contracts\User as SocialUser;

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
    public function findSocialAccount(string $socialServiceName, SocialUser $socialUser)
    {
        $socialAccountRecord = (array)$this->socialAccounts->getSocialAccount($socialUser->getId(), $socialServiceName);
        if (!$socialAccountRecord) {
            return null;
        }
        return new SocialAccountValueObject($socialAccountRecord);
    }

    /**
     * {@inheritdoc}
     */
    public function registerUser(SocialUser $socialUser)
    {
        return $this->users->setUser($socialUser->getEmail(), $socialUser->getName());
    }

    /**
     * {@inheritdoc}
     */
    public function associationSocialAccount(int $userId, string $socialServiceName, SocialUser $socialUser, UserValueObject $userValueObject)
    {
        $socialUserObject = new SocialUserValueObject($socialServiceName, $socialUser);
        $socialUserEntity = new SocialUserEntity($userId, $userValueObject, $socialUserObject);
        $this->socialAccounts->setSocialAccount($socialUserEntity->toArray());
    }
}
