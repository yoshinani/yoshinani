<?php

namespace Domain\Entities;

use Domain\ValueObjects\UserValueObject;
use Illuminate\Contracts\Support\Arrayable;

/**
 * Class UserEntity
 * @package Domain\Entities
 */
class UserEntity implements Arrayable
{
    private $id;
    private $userName;
    private $userEmail;

    /**
     * UserEntity constructor.
     * @param int $userId
     * @param UserValueObject $userValueObject
     */
    public function __construct(
        int $userId,
        UserValueObject $userValueObject
    )
    {
        $this->id        = $userId;
        $this->userName  = $userValueObject->getUserName();
        $this->userEmail = $userValueObject->getUserEmail();
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'id'        => $this->id,
            'userName'  => $this->userName,
            'userEmail' => $this->userEmail
        ];
    }
}