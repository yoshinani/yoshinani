<?php

namespace Domain\ValueObjects;

use stdClass;

/**
 * Class UserValueObject
 * @package Domain\ValueObjects
 */
class UserValueObject
{
    private $userName;
    private $userEmail;

    /**
     * UserValueObject constructor.
     * @param stdClass $userRecord
     */
    public function __construct(stdClass $userRecord)
    {
        $this->userName = $userRecord->name;
        $this->userEmail = $userRecord->email;
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
}
