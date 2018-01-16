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
        return $this->user->nickName;
    }

    /**
     * @return null|string
     */
    public function getName(): ?string
    {
        dd($this->user);
        return $this->user->name;
    }

}
