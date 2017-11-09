<?php

namespace Domain\ValueObjects;

class SocialAccountValueObject
{
    protected $userId;
    protected $socialUserName;
    protected $socialUserId;

    public function __construct(array $socialAccountRecord)
    {
        $this->userId         = $socialAccountRecord['user_id'];
        $this->socialUserName = $socialAccountRecord['social_user_name'];
        $this->socialUserId   = $socialAccountRecord['social_user_id'];
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function getSocialServiceName()
    {
        return $this->socialUserName;
    }

    public function getSocialUserId()
    {
        return$this->socialUserId;
    }
}