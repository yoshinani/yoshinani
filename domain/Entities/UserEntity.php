<?php

namespace Domain\Entities;

use Domain\ValueObjects\NameValueObject;
use Domain\ValueObjects\EmailValueObject;
use Illuminate\Contracts\Support\Arrayable;
use stdClass;

/**
 * Class UserEntity
 * @package Domain\Entities
 */
class UserEntity implements Arrayable
{
    private $id;
    private $email;
    private $name;

    /**
     * UserEntity constructor.
     * @param stdClass $userRecord
     * @internal param int $userId
     */
    public function __construct(
        stdClass $userRecord
    ) {
        $this->id = $userRecord->id;
        $this->email = new EmailValueObject($userRecord);
        $this->name = new NameValueObject($userRecord);
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
            'userName' => $this->name->getName(),
            'userNickName' => $this->name->getNickName(),
            'userEmail' => $this->email->getEmail(),
        ];
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUserName(): string
    {
        return $this->name->getName();
    }

    /**
     * @return string
     */
    public function getUserEmail(): string
    {
        return $this->email->getEmail();
    }
}
