<?php

namespace Domain\ValueObjects;

use stdClass;

/**
 * Class NickNameValueObject
 * @package Domain\ValueObjects
 */
class NickNameValueObject
{
    private $user;

    /**
     * NickNameValueObject constructor.
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
}
