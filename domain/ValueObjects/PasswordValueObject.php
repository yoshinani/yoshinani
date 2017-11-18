<?php

namespace Domain\ValueObjects;

use stdClass;

class PasswordValueObject
{
    private $userPassword;

    public function __construct(stdClass $userRecord)
    {
        $this->userPassword = $userRecord->password;
    }

    /**
     * @return string
     */
    public function getUserPassword(): string
    {
        return decrypt($this->userPassword);
    }
}