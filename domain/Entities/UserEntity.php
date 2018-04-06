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
    private $user;

    /**
     * UserEntity constructor.
     * @param stdClass $userRecord
     * @internal param int $userId
     */
    public function __construct(
        stdClass $userRecord
    ) {
        $this->id   = $userRecord->id;
        $this->user = new UserValueObject($userRecord);
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id'        => $this->getUserId(),
            'userName'  => $this->getUserName(),
            'userEmail' => $this->getUserEmail(),
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
}
