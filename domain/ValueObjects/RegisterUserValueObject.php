<?php

namespace Domain\ValueObjects;

/**
 * Class RegisterUserValueObject
 * @package Domain\ValueObjects
 */
class RegisterUserValueObject
{
    private $userName;
    private $userEmail;
    private $userPassword;

    /**
     * RegisterUserValueObject constructor.
     * @param $oldRequest
     */
    public function __construct($oldRequest)
    {
        $this->userName = $oldRequest['name'];
        $this->userEmail = $oldRequest['email'];
        $this->userPassword = $oldRequest['password'];
    }

    /**
     * @return string
     */
    public function getUserName(): string
    {
        return $this->userName;
    }

    /**
     * @return string
     */
    public function getUserEmail(): string
    {
        return $this->userEmail;
    }

    /**
     * @return string
     */
    public function getUserPassword(): string
    {
        return encrypt($this->userPassword);
    }
}
