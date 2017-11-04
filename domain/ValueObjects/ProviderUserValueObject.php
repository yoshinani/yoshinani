<?php

namespace Domain\ValueObjects;

use Laravel\Socialite\Contracts\User as ProviderUser;

class ProviderUserValueObject
{
    protected $providerName;
    protected $id;
    protected $name;
    protected $email;

    public function __construct(
        string $provider,
        ProviderUser $providerUser
    )
    {
        $this->providerName = $provider;
        $this->id           = $providerUser->getId();
        $this->name         = $providerUser->getName();
        $this->email        = $providerUser->getEmail();
    }

    public function getProviderName()
    {
        return $this->providerName;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}