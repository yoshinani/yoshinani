<?php

namespace Domain\Entities;

use Domain\ValueObjects\PasswordValueObject;
use Domain\ValueObjects\TimeStampValueObject;
use Illuminate\Contracts\Support\Arrayable;
use stdClass;

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
     * @param stdClass $userRecord
     */
    public function __construct(
        int $userId,
        stdClass $userRecord
    ) {
        $this->id = $userId;
        $passwordValueObject = new PasswordValueObject($userRecord);
        $this->password = $passwordValueObject->getEncryptionPassword();
        $timeStampValueObject = new TimeStampValueObject();
        $this->createdAt = $timeStampValueObject->getNow();
        $this->updatedAt = $timeStampValueObject->getNow();
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'password' => $this->password,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }

    /**
     * @return null|string
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    /**
     * @return string
     */
    public function getUpdatedAt(): string
    {
        return$this->updatedAt;
    }
}
