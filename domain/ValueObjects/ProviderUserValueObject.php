<?php

namespace Domain\ValueObjects;

use Laravel\Socialite\Contracts\User as ProviderUser;

class ProviderUserValueObject
{
    private $userId;
    private $providerName;
    private $providerUserId;
    private $providerUserName;
    private $providerUserEmail;

    public function __construct(int $userId, string $provider, ProviderUser $providerUser)
    {
        $this->userId = $userId;
        $this->providerName = $provider;
        $this->providerUserId = $providerUser->getId();
        $this->providerUserName = $providerUser->getName();
        $this->providerUserEmail = $providerUser->getEmail();
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function getProviderName()
    {
        return $this->providerName;
    }

    public function getProviderUserId()
    {
        return $this->providerUserId;
    }

    public function getProviderUserName()
    {
        return $this->providerUserName;
    }

    public function getProviderUserEmail()
    {
        return $this->providerUserEmail;
    }
}