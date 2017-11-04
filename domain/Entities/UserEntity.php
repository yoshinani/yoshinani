<?php

namespace Domain\Entities;

use Domain\ValueObjects\UserValueObject;
use Illuminate\Contracts\Support\Arrayable;

class UserEntity implements Arrayable
{
    private $id;
    private $userId;
    private $userName;
    private $userEmail;


    public function __construct(
        int $userId,
        UserValueObject $userValueObject
    )
    {
        $this->id = $userId;
        $this->userId = $userId;$userValueObject->getId();
        $this->userName = $userValueObject->getName();
        $this->userEmail = $userValueObject->getEmail();
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'id' => $this->id,
            'userId' => $this->userId,
            'userName' => $this->userName,
            'userEmail' => $this->userEmail
        ];
    }
}