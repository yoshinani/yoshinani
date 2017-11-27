<?php

namespace Domain\Entities;

use Domain\ValueObjects\PasswordValueObject;
use Domain\ValueObjects\TimeStampValueObject;
use Illuminate\Contracts\Support\Arrayable;

/**
 * Class RegisterUserPasswordEntity
 * @package Domain\Entities
 */
class RegisterUserPasswordEntity implements Arrayable
{
    private $id;
    private $password;
    private $createdAt;
    private $updatedAt;

    /**
     * RegisterUserPasswordEntity constructor.
     * @param int $userId
     * @param PasswordValueObject $passwordValueObject
     * @param TimeStampValueObject $timeStampValueObject
     */
    public function __construct(
        int $userId,
        PasswordValueObject $passwordValueObject,
        TimeStampValueObject $timeStampValueObject
    ) {
        $this->id = $userId;
        $this->password = $passwordValueObject->getEncryptionPassword();
        $this->createdAt = $timeStampValueObject->getNow();
        $this->updatedAt = $timeStampValueObject->getNow();
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
            'password' => $this->password,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return string
     */
    public function getUpdatedAt()
    {
        return$this->updatedAt;
    }
}
