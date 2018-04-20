<?php
namespace Infrastructure\Interfaces\Auth;

use Domain\Entities\UserEntity;
use stdClass;

/**
 * Interface ManualRepositoryInterface
 * @package Infrastructure\Interfaces\Auth
 */
interface ManualRepositoryInterface
{
    /**
     * @param int $userId
     * @return stdClass|null
     */
    public function getUserPassword(int $userId): ?stdClass;

    /**
     * @param string $email
     * @return UserEntity|null
     */
    public function getUser(string $email): ?UserEntity;

    /**
     * @param array $oldRequest
     * @return UserEntity
     */
    public function registerUser(array $oldRequest): UserEntity;
}
