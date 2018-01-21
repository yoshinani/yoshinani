<?php

namespace Domain\ValueObjects;

use stdClass;

/**
 * Class NameValueObject
 * @package Domain\ValueObjects
 */
class NameValueObject
{
    private $user;

    /**
     * NameValueObject constructor.
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
        return $this->user->nickname;
    }

    /**
     * @return null|string
     */
    public function getName(): ?string
    {
        return $this->user->name;
    }

}
