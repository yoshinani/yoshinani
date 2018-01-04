<?php

namespace Domain\Entities;

use Domain\ValueObjects\PasswordValueObject;
use Illuminate\Contracts\Support\Arrayable;
use stdClass;

/**
 * Class RegisterUserPasswordEntity
 * @package Domain\Entities
 */
class UserPasswordEntity implements Arrayable
{
    private $id;
    private $password;

    /**
     * UserPasswordEntity constructor.
     * @param int $userId
     * @param stdClass $userPasswordRecord
     */
    public function __construct(
        int $userId,
        stdClass $userPasswordRecord
    ) {
        $this->id = $userId;
        $this->password = new PasswordValueObject($userPasswordRecord);
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
            'password' => $this->password->getDecryptionPassword(),
        ];
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password->getDecryptionPassword();
    }
}
