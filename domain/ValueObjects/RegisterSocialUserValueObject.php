<?php

namespace Domain\ValueObjects;

use Laravel\Socialite\Contracts\User as SocialUser;

/**
 * Class SocialUserValueObject
 * @package Domain\ValueObjects
 */
class RegisterSocialUserValueObject
{
    private $driver;
    private $socialUser;

    /**
     * RegisterSocialUserValueObject constructor.
     * @param string $driverName
     * @param SocialUser $socialUser
     */
    public function __construct(string $driverName, SocialUser $socialUser)
    {
        $this->driver = $driverName;
        $this->socialUser = $socialUser;
    }

    /**
     * @return string
     */
    public function getSocialServiceName(): string
    {
        return $this->driver;
    }

    /**
     * @return string
     */
    public function getSocialUserId(): string
    {
        return $this->socialUser->getId();
    }
}
