<?php

namespace Domain\Entities;

use Domain\ValueObjects\PasswordValueObject;
use Illuminate\Contracts\Support\Arrayable;

/**
 * Class RegisterUserPasswordEntity
 * @package Domain\Entities
 */
class RegisterUserPasswordEntity implements Arrayable
{
    private $id;
    private $password;

    /**
     * UserEntity constructor.
     * @param int $userId
     * @param PasswordValueObject $passwordValueObject
     * @internal param int $userId
     */
    public function __construct(
        int $userId,
        PasswordValueObject $passwordValueObject
    ) {
        $this->id = $userId;
        $this->password = $passwordValueObject->getEncryptionPassword();
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'id' => $this->id,
            'password' => $this->password,
        ];
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }
}
