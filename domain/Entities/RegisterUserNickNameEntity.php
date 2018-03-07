<?php

namespace Domain\Entities;

use Domain\ValueObjects\NickNameValueObject;
use Domain\ValueObjects\TimeStampValueObject;
use Illuminate\Contracts\Support\Arrayable;
use stdClass;

/**
 * Class RegisterUserNickNameEntity
 * @package Domain\Entities
 */
class RegisterUserNickNameEntity implements Arrayable
{
    private $id;
    private $nickname;
    private $timeStamp;

    /**
     * RegisterUserPasswordEntity constructor.
     * @param int $userId
     * @param stdClass $userRecord
     */
    public function __construct(
        int $userId,
        stdClass $userRecord
    ) {
        $this->id = $userId;
        $this->nickname = new NickNameValueObject($userRecord);
        $this->timeStamp = new TimeStampValueObject();
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'nickname' => $this->nickname->getNickName(),
            'created_at' => $this->timeStamp->getNow(),
            'updated_at' => $this->timeStamp->getNow(),
        ];
    }

    /**
     * @return string
     */
    public function getNickName(): string
    {
        return $this->nickname->getNickName();
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->timeStamp->getNow();
    }

    /**
     * @return string
     */
    public function getUpdatedAt(): string
    {
        return $this->timeStamp->getNow();
    }
}
