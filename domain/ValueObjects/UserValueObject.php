<?php

namespace Domain\ValueObjects;

class UserValueObject
{
    private $userId;
    private $userName;
    private $userEmail;

    public function __construct($userInfo)
    {
        $this->userId    = $userInfo->id;
        $this->userName  = $userInfo->name;
        $this->userEmail = $userInfo->email;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getUserName(): string
    {
        return $this->userName;
    }

    public function getUserEmail(): string
    {
        return $this->userEmail;
    }

}