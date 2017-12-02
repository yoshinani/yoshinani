<?php

namespace Domain\ValueObjects;

use stdClass;

/**
 * Class PasswordValueObject
 * @package Domain\ValueObjects
 */
class PasswordValueObject
{
    const STATUS = 'Unregistered';

    private $userPassword;

    /**
     * PasswordValueObject constructor.
     * @param stdClass $userRecord
     */
    public function __construct(stdClass $userRecord)
    {
        $this->userPassword = $userRecord->password;
    }

    /**
     * @return null|string
     */
    public function getEncryptionPassword(): ?string
    {
        return encrypt($this->userPassword);
    }

    /**
     * @return string
     */
    public function getDecryptionPassword(): string
    {
        if (is_null($this->userPassword)) {
            return self::STATUS;
        }
        return decrypt($this->userPassword);
    }
}
