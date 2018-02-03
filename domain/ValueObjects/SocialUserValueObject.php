<?php

namespace Domain\ValueObjects;

use Laravel\Socialite\Contracts\User as SocialUser;

/**
 * Class SocialUserValueObject
 * @package Domain\ValueObjects
 */
class SocialUserValueObject
{
    private $driver;
    private $socialUser;

    /**
     * SocialUserValueObject constructor.
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
    public function getDriverName(): string
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
