<?php

namespace Domain\Entities;

use Domain\ValueObjects\TimeStampValueObject;
use Domain\ValueObjects\UserValueObject;
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
     * @param TimeStampValueObject $timeStampValueObject
     */
    public function __construct(stdClass $userRecord, UserValueObject $userValueObject, TimeStampValueObject $timeStampValueObject)
    {
        $this->email = $userRecord->email;
        $this->name = $userValueObject->getUserName();
        $this->createdAt = $timeStampValueObject->getMakeUp();
        $this->updatedAt = $timeStampValueObject->getMakeUp();
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
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
