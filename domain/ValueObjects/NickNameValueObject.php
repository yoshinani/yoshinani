<?php

namespace Domain\ValueObjects;

use stdClass;

/**
 * Class NickNameValueObject
 * @package Domain\ValueObjects
 */
class NickNameValueObject
{
    const NO_EXIST = 'Unregistered';

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
     * @return string
     */
    public function getNickName(): string
    {
        if (is_null($this->user->nickname)) {
            return self::NO_EXIST;
        }
        return $this->user->nickname;
    }
}
