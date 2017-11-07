<?php

namespace Domain\ValueObjects;

class SocialAccountValueObject
{
    protected $userId;
    protected $providerName;
    protected $providerUserId;

    public function __construct(array $socialAccountRecord)
    {
        $this->userId          = $socialAccountRecord['user_id'];
        $this->providerName    = $socialAccountRecord['provider_name'];
        $this->providerUserId  = $socialAccountRecord['provider_user_id'];
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
        return$this->providerUserId;
    }
}