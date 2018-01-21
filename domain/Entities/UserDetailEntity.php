<?php

namespace Domain\Entities;

use Domain\ValueObjects\{
    NameValueObject, EmailValueObject, PasswordValueObject
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
    private $email;
    private $name;
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
        $this->email = new EmailValueObject($userDetail);
        $this->name = new NameValueObject($userDetail);
        $this->password = new PasswordValueObject($userDetail);
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
            'userEmail' => $this->email->getEmail(),
            'userNickName' => $this->name->getNickName(),
            'userName' => $this->name->getName(),
            'userPassword' => $this->password->getDecryption(),
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
    public function getUserEmail(): string
    {
        return $this->email->getEmail();
    }

    /**
     * @return null|string
     */
    public function getUserNickName(): ?string
    {
        return $this->name->getNickName();
    }

    /**
     * @return string
     */
    public function getUserName(): ?string
    {
        return $this->name->getName();
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password->getDecryption();
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
