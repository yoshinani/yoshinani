<?php

namespace Infrastructure\Repositories;

use Domain\Entities\ProviderUserEntity;
use Domain\ValueObjects\ProviderUserValueObject;
use Domain\ValueObjects\SocialAccountValueObject;
use Domain\ValueObjects\UserValueObject;
use Infrastructure\Interfaces\SocialRepositoryInterface;
use Infrastructure\DataSources\Database\SocialAccounts;
use Infrastructure\DataSources\Database\Users;
use Laravel\Socialite\Contracts\User as ProviderUser;

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

    public function findUser(ProviderUser $providerUser)
    {
        $result = $this->users->findUser($providerUser->getEmail());
        if (!$result) {
            return null;
        }
        return new UserValueObject($result);
    }

    public function getUserId(ProviderUser $providerUser)
    {
        return $this->users->getUserId($providerUser->getEmail());
    }

    public function findSocialAccount(ProviderUser $providerUser, $provider)
    {
        $socialAccountRecord = (array)$this->socialAccounts->getSocialAccount($provider, $providerUser->getId());
        if (!$socialAccountRecord) {
            return null;
        }
        return new SocialAccountValueObject($socialAccountRecord);
    }

    public function registerUser(ProviderUser $providerUser)
    {
        return $this->users->setUser($providerUser->getEmail(), $providerUser->getName());
    }

    public function associationSocialAccount(ProviderUser $providerUser, $provider, UserValueObject $userValueObject, int $userId)
    {
        $providerUserObject = new ProviderUserValueObject($userId, $provider, $providerUser);
        $providerUserEntity = new ProviderUserEntity($userId, $userValueObject, $providerUserObject);
        $this->socialAccounts->setSocialAccount($providerUserEntity->toArray());
    }
}