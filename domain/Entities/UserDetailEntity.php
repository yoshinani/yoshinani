<?php

namespace Domain\Entities;

use Domain\ValueObjects\{
    UserValueObject,
    PasswordValueObject
};
use Illuminate\Contracts\Support\Arrayable;
use stdClass;

/**
 * Class UserDetailEntity
 * @package Domain\Entities
 */
class UserDetailEntity implements Arrayable
{
    private $id;
    private $name;
    private $email;
    private $password;

    /**
     * UserEntity constructor.
     * @param stdClass $userRecord
     * @param UserValueObject $userValueObject
     * @param PasswordValueObject $passwordValueObject
     * @internal param int $userId
     */
    public function __construct(
        stdClass $userRecord,
        UserValueObject $userValueObject,
        PasswordValueObject $passwordValueObject
    ) {
        $this->id = $userRecord->id;
        $this->name = $userValueObject->getUserName();
        $this->email = $userValueObject->getUserEmail();
        $this->password = $passwordValueObject->getDecryptionPassword();
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
            'userPassword' => $this->password,
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
        return $this->name;
    }

    /**
     * @return string
     */
    public function getUserEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }
}
