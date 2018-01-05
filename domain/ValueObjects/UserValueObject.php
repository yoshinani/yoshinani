<?php

namespace Domain\ValueObjects;

use stdClass;

/**
 * Class UserValueObject
 * @package Domain\ValueObjects
 */
class UserValueObject
{
    private $user;

    /**
     * UserValueObject constructor.
     * @param stdClass $userRecord
     */
    public function __construct(stdClass $userRecord)
    {
        $this->user = $userRecord;
    }

    /**
     * @return string
     */
    public function getUserName(): string
    {
        return $this->user->name;
    }

    /**
     * @return string
     */
    public function getUserEmail(): string
    {
        return $this->user->email;
    }
}
