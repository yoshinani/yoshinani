<?php

namespace Domain\ValueObjects;

use stdClass;

/**
 * Class PasswordValueObject
 * @package Domain\ValueObjects
 */
class PasswordValueObject
{
    const NO_EXIST = 'Unregistered';

    private $password;

    /**
     * PasswordValueObject constructor.
     * @param stdClass $userRecord
     */
    public function __construct(stdClass $userRecord)
    {
        $this->password = $userRecord->password;
    }

    /**
     * @return string
     */
    public function getEncryption(): string
    {
        return encrypt($this->password);
    }

    /**
     * @return string
     */
    public function getDecryption(): string
    {
        if (is_null($this->password)) {
            return self::NO_EXIST;
        }
        return decrypt($this->password);
    }
}
