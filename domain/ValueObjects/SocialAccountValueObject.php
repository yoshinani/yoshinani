<?php

namespace Domain\ValueObjects;

use stdClass;

/**
 * Class SocialAccountValueObject
 * @package Domain\ValueObjects
 */
class SocialAccountValueObject
{
    protected $userId;
    protected $socialServiceName;
    protected $socialUserId;

    /**
     * SocialAccountValueObject constructor.
     * @param stdClass $socialAccountRecord
     */
    public function __construct(stdClass $socialAccountRecord)
    {
        $this->userId = $socialAccountRecord->user_id;
        $this->socialServiceName = $socialAccountRecord->social_service_name;
        $this->socialUserId = $socialAccountRecord->social_user_id;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function getSocialServiceName(): string
    {
        return $this->socialServiceName;
    }

    /**
     * @return string
     */
    public function getSocialUserId(): string
    {
        return $this->socialUserId;
    }
}
