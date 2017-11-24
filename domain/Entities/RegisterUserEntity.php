<?php

namespace Domain\Entities;

use Domain\ValueObjects\PasswordValueObject;
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

    /**
     * RegisterUserEntity constructor.
     * @param stdClass $userRecord
     * @param UserValueObject $userValueObject
     * @internal param string $userEmail
     */
    public function __construct(stdClass $userRecord, UserValueObject $userValueObject)
    {
        $this->email = $userRecord->email;
        $this->userValueObject = $userValueObject;
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
            'name' => $this->userValueObject->getUserName(),
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

}