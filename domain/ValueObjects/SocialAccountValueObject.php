<?php

namespace Domain\ValueObjects;

/**
 * Class SocialAccountValueObject
 * @package Domain\ValueObjects
 */
class SocialAccountValueObject
{
    protected $userId;
    protected $socialUserName;
    protected $socialUserId;

    /**
     * SocialAccountValueObject constructor.
     * @param array $socialAccountRecord
     */
    public function __construct(array $socialAccountRecord)
    {
        $this->userId = $socialAccountRecord['user_id'];
        $this->socialUserName = $socialAccountRecord['social_user_name'];
        $this->socialUserId = $socialAccountRecord['social_user_id'];
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
        return $this->socialUserName;
    }

    /**
     * @return mixed
     */
    public function getSocialUserId()
    {
        return$this->socialUserId;
    }
}
