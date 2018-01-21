<?php

namespace Domain\ValueObjects;

use stdClass;

/**
 * Class EmailValueObject
 * @package Domain\ValueObjects
 */
class EmailValueObject
{
    private $user;

    /**
     * EmailValueObject constructor.
     * @param stdClass $userRecord
     */
    public function __construct(stdClass $userRecord)
    {
        $this->user = $userRecord;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->user->email;
    }
}
