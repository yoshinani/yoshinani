<?php

namespace Domain\ValueObjects;

use Laravel\Socialite\Contracts\User as ProviderUser;

class ProviderUserValueObject
{
    private $providerName;
    private $providerUserId;
    private $providerUserName;
    private $providerUserEmail;

    public function __construct(string $provider, ProviderUser $providerUser)
    {
        $this->providerName      = $provider;
        $this->providerUserId    = $providerUser->getId();
        $this->providerUserName  = $providerUser->getName();
        $this->providerUserEmail = $providerUser->getEmail();
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