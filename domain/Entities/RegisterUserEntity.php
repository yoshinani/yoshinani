<?php

namespace Domain\Entities;

use Domain\ValueObjects\{
    UserValueObject,
    TimeStampValueObject
};
use Illuminate\Contracts\Support\Arrayable;
use stdClass;

/**
 * Class RegisterUserEntity
 * @package Domain\Entities
 */
class RegisterUserEntity implements Arrayable
{
    private $email;
    private $name;
    private $createdAt;
    private $updatedAt;

    /**
     * RegisterUserEntity constructor.
     * @param stdClass $userRecord
     * @param UserValueObject $userValueObject
     */
    public function __construct(stdClass $userRecord, UserValueObject $userValueObject)
    {
        $this->email = $userRecord->email;
        $this->name = $userValueObject->getUserName();
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
            'email' => $this->email,
            'name' => $this->name,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
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
