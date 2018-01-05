<?php

namespace Domain\ValueObjects;

use stdClass;

/**
 * Class SocialAccountValueObject
 * @package Domain\ValueObjects
 */
class SocialAccountValueObject
{
    private $socialAccount;

    /**
     * SocialAccountValueObject constructor.
     * @param stdClass $socialAccountRecord
     */
    public function __construct(stdClass $socialAccountRecord)
    {
        $this->socialAccount = $socialAccountRecord;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->socialAccount->user_id;
    }

    /**
     * @return string
     */
    public function getSocialServiceName(): string
    {
        return $this->socialAccount->social_service_name;
    }

    /**
     * @return string
     */
    public function getSocialUserId(): string
    {
        return $this->socialAccount->social_user_id;
    }
}
