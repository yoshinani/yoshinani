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
    private $passwordValueObject;

    /**
     * RegisterUserEntity constructor.
     * @param stdClass $userRecord
     * @param UserValueObject $userValueObject
     * @param PasswordValueObject $passwordValueObject
     * @internal param string $userEmail
     */
    public function __construct(stdClass $userRecord, UserValueObject $userValueObject, PasswordValueObject $passwordValueObject = null)
    {
        $this->email = $userRecord->email;
        $this->userValueObject = $userValueObject;
        $this->passwordValueObject = $passwordValueObject;
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
            'password' => $this->passwordValueObject->getEncryptionPassword(),
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

    /**
     * @return null|string
     */
    public function getPassword():?string
    {
        if (is_null($this->passwordValueObject)) {
            return null;
        }
        return $this->passwordValueObject->getEncryptionPassword();
    }
}