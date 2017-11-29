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
        PasswordValueObject $passwordValueObject = null
    ) {
        $this->id = $userRecord->id;
        $this->name = $userValueObject->getUserName();
        $this->email = $userValueObject->getUserEmail();
        if (!is_null($passwordValueObject)) {
            $this->password = $passwordValueObject->getDecryptionPassword();
        }
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


    public function getUserId(): int
    {
        return $this->id;
    }

    public function getUserEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string 
    {
        if (is_null($this->password)) {
            return null;
        }
        return $this->password;
    }
}
