<?php

namespace Domain\Entities;

use Domain\ValueObjects\UserValueObject;
use Illuminate\Contracts\Support\Arrayable;
use stdClass;

/**
 * Class UserEntity
 * @package Domain\Entities
 */
class UserEntity implements Arrayable
{
    private $id;
    private $name;
    private $email;

    /**
     * UserEntity constructor.
     * @param stdClass $userRecord
     * @param UserValueObject $userValueObject
     * @internal param int $userId
     */
    public function __construct(
        stdClass $userRecord,
        UserValueObject $userValueObject
    ) {
        $this->id = $userRecord->id;
        $this->name = $userValueObject->getUserName();
        $this->email = $userValueObject->getUserEmail();
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
            'userName' => $this->name,
            'userEmail' => $this->email,
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
    public function getUserEmail(): string
    {
        return $this->email;
    }
}
