<?php
namespace Infrastructure\Interfaces\Auth;

use Domain\Entities\UserDetailEntity;
use Domain\Entities\UserEntity;
use Domain\Entities\Registers\UserEntity as RegisterUserEntity;
use Domain\Entities\UserPasswordEntity;
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
     * @return RegisterUserEntity|null
     */
    public function getUser(string $email): ?RegisterUserEntity;

    /**
     * @param array $oldRequest
     * @return RegisterUserEntity
     */
    public function registerUser(array $oldRequest): RegisterUserEntity;
}
