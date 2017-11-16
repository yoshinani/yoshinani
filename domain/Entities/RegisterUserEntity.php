<?php

namespace Domain\Entities;

use Domain\ValueObjects\RegisterUserValueObject;
use Illuminate\Contracts\Support\Arrayable;

/**
 * Class RegisterUserEntity
 * @package Domain\Entities
 */
class RegisterUserEntity implements Arrayable
{
    private $email;
    private $registerUserValueObject;

    /**
     * RegisterUserEntity constructor.
     * @param string $userEmail
     * @param RegisterUserValueObject $registerUserValueObject
     */
    public function __construct(string $userEmail, RegisterUserValueObject $registerUserValueObject)
    {
        $this->email = $userEmail;
        $this->registerUserValueObject = $registerUserValueObject;
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
            'name' => $this->registerUserValueObject->getUserName(),
            'password' => $this->registerUserValueObject->getUserPassword(),
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
        return $this->registerUserValueObject->getUserName();
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->registerUserValueObject->getUserPassword();
    }
}