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
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @return mixed
     */
    public function getSocialServiceName()
    {
        return $this->socialServiceName;
    }

    /**
     * @return mixed
     */
    public function getSocialUserId()
    {
        return $this->socialUserId;
    }
}
