<?php
namespace Infrastructure\Interfaces\Auth;

use Domain\Entities\UserDetailEntity;
use Domain\Entities\UserEntity;
use Domain\Entities\Registers\UserEntity as RegisterUserEntity;
use Domain\Entities\UserPasswordEntity;

/**
 * Interface ManualRepositoryInterface
 * @package Infrastructure\Interfaces\Auth
 */
interface ManualRepositoryInterface
{
    /**
     * @param string $email
     * @return UserEntity|null
     */
    public function findUser(string $email): ?UserEntity;

    /**
     * @param int $userId
     * @return UserPasswordEntity|null
     */
    public function getUserPassword(int $userId): ?UserPasswordEntity;

    /**
     * @param array $oldRequest
     * @return int|null
     */
    public function getUserId(array $oldRequest): ?int;

    /**
     * @param int $userId
     * @return UserDetailEntity|null
     */
    public function getUserDetail(int $userId): ?UserDetailEntity;

    /**
     * @param array $oldRequest
     * @return RegisterUserEntity
     */
    public function registerUser(array $oldRequest): RegisterUserEntity;
}
