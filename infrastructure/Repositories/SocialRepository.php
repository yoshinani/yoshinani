<?php

namespace Infrastructure\Repositories;

use Domain\Entities\ProviderUserEntity;
use Domain\Entities\UserEntity;
use Domain\ValueObjects\ProviderUserValueObject;
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
        $result = $this->socialAccounts->getSocialAccount($providerUser->getId(), $providerUser->getName());
        if (!$result) {
            return null;
        }
        return new ProviderUserValueObject($provider, $providerUser);
    }

    public function registerUser(ProviderUser $providerUser, string $provider)
    {
        $providerUserObject = new ProviderUserValueObject($provider, $providerUser);
        $providerUserEntity = new ProviderUserEntity($providerUser->getId(), $providerUserObject);
        return $this->users->setUser($providerUserEntity->toArray());
    }

    public function associationSocialAccount(ProviderUser $providerUser, $provider, UserValueObject $userValueObject, int $userId)
    {
        $providerUserObject = new ProviderUserValueObject($provider, $providerUser);
        $providerUserEntity = new ProviderUserEntity($providerUser->getId(), $providerUserObject);
        $userEntity = new UserEntity($userId, $userValueObject);
        $this->socialAccounts->setSocialAccount($providerUserEntity->toArray(), $userEntity->toArray());
    }
}