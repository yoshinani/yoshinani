<?php

namespace Infrastructure\Repositories;

use Domain\Entities\SocialUserEntity;
use Domain\ValueObjects\SocialAccountValueObject;
use Domain\ValueObjects\SocialUserValueObject;
use Domain\ValueObjects\UserValueObject;
use Infrastructure\Interfaces\SocialRepositoryInterface;
use Infrastructure\DataSources\Database\SocialAccounts;
use Infrastructure\DataSources\Database\Users;
use Laravel\Socialite\Contracts\User as SocialUser;

class SocialRepository implements SocialRepositoryInterface
{
    private $socialAccounts;
    private $users;

    public function __construct(
        SocialAccounts $socialAccounts,
        Users          $users
    )
    {
        $this->socialAccounts = $socialAccounts;
        $this->users          = $users;
    }

    public function findUser(SocialUser $socialUser)
    {
        $result = $this->users->findUser($socialUser->getEmail());
        if (!$result) {
            return null;
        }
        return new UserValueObject($result);
    }

    public function getUserId(SocialUser $socialUser)
    {
        return $this->users->getUserId($socialUser->getEmail());
    }

    public function findSocialAccount(string $socialServiceName, SocialUser $socialUser)
    {
        $socialAccountRecord = (array)$this->socialAccounts->getSocialAccount($socialUser->getId(), $socialServiceName);
        if (!$socialAccountRecord) {
            return null;
        }
        return new SocialAccountValueObject($socialAccountRecord);
    }

    public function registerUser(SocialUser $socialUser)
    {
        return $this->users->setUser($socialUser->getEmail(), $socialUser->getName());
    }

    public function associationSocialAccount(int $userId, string $socialServiceName, SocialUser $socialUser, UserValueObject $userValueObject)
    {
        $socialUserObject = new SocialUserValueObject($socialServiceName, $socialUser);
        $socialUserEntity = new SocialUserEntity($userId, $userValueObject, $socialUserObject);
        $this->socialAccounts->setSocialAccount($socialUserEntity->toArray());
    }
}