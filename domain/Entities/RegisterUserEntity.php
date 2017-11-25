<?php

namespace Domain\Entities;

use Domain\ValueObjects\PasswordValueObject;
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
    private $userValueObject;
    private $timeStampValueObject;


    /**
     * RegisterUserEntity constructor.
     * @param stdClass $userRecord
     * @param UserValueObject $userValueObject
     * @param TimeStampValueObject $timeStampValueObject
     */
    public function __construct(stdClass $userRecord, UserValueObject $userValueObject, TimeStampValueObject $timeStampValueObject)
    {
        $this->email = $userRecord->email;
        $this->userValueObject = $userValueObject;
        $this->timeStampValueObject = $timeStampValueObject;
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
            'name' => $this->getName(),
            'created_at' => $this->getCreatedAt(),
            'updated_at' => $this->getUpdatedAt(),
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
        return $this->userValueObject->getUserName();
    }

    public function getCreatedAt()
    {
        return $this->timeStampValueObject->getCreatedAt();
    }

    public function getUpdatedAt()
    {
        return$this->timeStampValueObject->getUpdatedAt();
    }
}
