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
     * @return null|string
     */
    public function getNickName(): ?string
    {
        return $this->user->nickName;
    }

    /**
     * @return null|string
     */
    public function getName(): ?string
    {
        return $this->user->name;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->user->email;
    }
}
