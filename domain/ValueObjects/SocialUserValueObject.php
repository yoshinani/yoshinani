<?php

namespace Domain\ValueObjects;

use Laravel\Socialite\Contracts\User as SocialUser;

class SocialUserValueObject
{
    private $socialServiceName;
    private $socialUserId;
    private $socialUserName;
    private $socialUserEmail;

    public function __construct(string $socialServiceName, SocialUser $socialUser)
    {
        $this->socialServiceName = $socialServiceName;
        $this->socialUserId      = $socialUser->getId();
        $this->socialUserName    = $socialUser->getName();
        $this->socialUserEmail   = $socialUser->getEmail();
    }

    public function getSocialServiceName()
    {
        return $this->socialServiceName;
    }

    public function getSocialUserId()
    {
        return $this->socialUserId;
    }

    public function getSocialUserName()
    {
        return $this->socialUserName;
    }

    public function getSocialUserEmail()
    {
        return $this->socialUserEmail;
    }
}