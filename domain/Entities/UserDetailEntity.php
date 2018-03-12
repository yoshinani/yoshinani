<?php
namespace Domain\Entities;

use Domain\ValueObjects\UserValueObject;
use Domain\ValueObjects\PasswordValueObject;
use Illuminate\Contracts\Support\Arrayable;
use stdClass;

/**
 * Class UserDetailEntity
 * @package Domain\Entities
 */
class UserDetailEntity implements Arrayable
{
    public const ON = 1;

    private $id;
    private $user;
    private $password;
    private $activeStatus;

    /**
     * UserDetailEntity constructor.
     * @param stdClass $userDetail
     */
    public function __construct(
        stdClass $userDetail
    ) {
        $this->id           = $userDetail->id;
        $this->user         = new UserValueObject($userDetail);
        $this->password     = new PasswordValueObject($userDetail);
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
            'id'           => $this->id,
            'userName'     => $this->user->getName(),
            'userEmail'    => $this->user->getEmail(),
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
    public function getUserName(): string
    {
        return $this->user->getName();
    }

    /**
     * @return string
     */
    public function getUserEmail(): string
    {
        return $this->user->getEmail();
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
        }

        return false;
    }
}
