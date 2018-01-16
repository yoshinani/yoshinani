<?php

namespace Domain\Entities;

use Domain\ValueObjects\{
    NameValueObject, UserValueObject, TimeStampValueObject
};
use Illuminate\Contracts\Support\Arrayable;
use stdClass;

/**
 * Class RegisterUserEntity
 * @package Domain\Entities
 */
class RegisterUserEntity implements Arrayable
{
    private $user;
    private $name;
    private $timeStamp;

    /**
     * RegisterUserEntity constructor.
     * @param stdClass $userRecord
     */
    public function __construct(stdClass $userRecord)
    {
        $this->user = new UserValueObject($userRecord);
        $this->name = new NameValueObject($userRecord);
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
            'email' => $this->user->getEmail(),
            'name' => $this->name->getName(),
            'nickName' => $this->name->getNickName(),
            'created_at' => $this->timeStamp->getNow(),
            'updated_at' => $this->timeStamp->getNow(),
        ];
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->user->getEmail();
    }

    /**
     * @return null|string
     */
    public function getName(): ?string
    {
        return $this->name->getName();
    }

    /**
     * @return null|string
     */
    public function getNickName(): ?string
    {
        return $this->name->getNickName();
    }

    /**
     * @return bool
     */
    public function getActive(): bool
    {
        return true;
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
