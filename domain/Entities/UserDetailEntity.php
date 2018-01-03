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
    CONST ON = 1;

    private $id;
    private $name;
    private $email;
    private $password;
    private $activeStatus;

    /**
     * UserDetailEntity constructor.
     * @param stdClass $userDetail
     */
    public function __construct(
        stdClass $userDetail
    ) {
        $this->id = $userDetail->id;
        $userValueObject = new UserValueObject($userDetail);
        $this->name = $userValueObject->getUserName();
        $this->email = $userValueObject->getUserEmail();
        $passwordValueObject = new PasswordValueObject($userDetail);
        $this->password = $passwordValueObject->getDecryptionPassword();
        $this->activeStatus = $userDetail->active;
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
            'activeStatus' => $this->activeStatus
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

    /**
     * @return bool
     */
    public function getActiveStatus(): bool
    {
        if ($this->activeStatus === self::ON) {
            return true;
        } else {
            return false;
        }
    }
}
