<?php

namespace Domain\ValueObjects;

/**
 * Class UserValueObject
 * @package Domain\ValueObjects
 */
class UserValueObject
{
    private $userId;
    private $userName;
    private $userEmail;

    /**
     * UserValueObject constructor.
     * @param $userInfo
     */
    public function __construct($userInfo)
    {
        $this->userId = $userInfo->id;
        $this->userName = $userInfo->name;
        $this->userEmail = $userInfo->email;
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
    public function getUserName(): string
    {
        return $this->userName;
    }

    /**
     * @return string
     */
    public function getUserEmail(): string
    {
        return $this->userEmail;
    }
}
