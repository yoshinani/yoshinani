<?php

namespace Domain\Entities;

use Domain\ValueObjects\{
    UserValueObject,
    TimeStampValueObject
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
    private $timeStamp;

    /**
     * RegisterUserEntity constructor.
     * @param stdClass $userRecord
     */
    public function __construct(stdClass $userRecord)
    {
        $this->user = new UserValueObject($userRecord);
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
            'email' => $this->user->getUserEmail(),
            'name' => $this->user->getUserName(),
            'created_at' => $this->timeStamp->getNow(),
            'updated_at' => $this->timeStamp->getNow(),
        ];
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->user->getUserEmail();
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->user->getUserName();
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
