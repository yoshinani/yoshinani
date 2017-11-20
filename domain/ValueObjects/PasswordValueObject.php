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
    public function getEncryptionPassword(): string
    {
        return encrypt($this->userPassword);
    }

    /**
     * @return string
     */
    public function getDecryptionPassword(): string
    {
        return decrypt($this->userPassword);
    }
}