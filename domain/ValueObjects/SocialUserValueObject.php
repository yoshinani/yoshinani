<?php

namespace Domain\ValueObjects;

use Laravel\Socialite\Contracts\User as SocialUser;

/**
 * Class SocialUserValueObject
 * @package Domain\ValueObjects
 */
class SocialUserValueObject
{
    private $socialServiceName;
    private $socialUserId;
    private $socialUserName;
    private $socialUserEmail;

    /**
     * SocialUserValueObject constructor.
     * @param string $socialServiceName
     * @param SocialUser $socialUser
     */
    public function __construct(string $socialServiceName, SocialUser $socialUser)
    {
        $this->socialServiceName = $socialServiceName;
        $this->socialUserId = $socialUser->getId();
        $this->socialUserName = $socialUser->getName();
        $this->socialUserEmail = $socialUser->getEmail();
    }

    /**
     * @return string
     */
    public function getSocialServiceName()
    {
        return $this->socialServiceName;
    }

    /**
     * @return string
     */
    public function getSocialUserId()
    {
        return $this->socialUserId;
    }

    /**
     * @return string
     */
    public function getSocialUserName()
    {
        return $this->socialUserName;
    }

    /**
     * @return string
     */
    public function getSocialUserEmail()
    {
        return $this->socialUserEmail;
    }
}
