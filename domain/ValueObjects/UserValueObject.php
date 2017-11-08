<?php

namespace Domain\ValueObjects;

use Illuminate\Contracts\Support\Arrayable;

class UserValueObject implements Arrayable
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

    public function toArray()
    {
        return [
            'userId'            => $this->userId,
            'userName'          => $this->userName,
            'userEmail'         => $this->userEmail,
        ];
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