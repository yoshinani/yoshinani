<?php

namespace Infrastructure\Interfaces;

use Domain\Entities\UserDetailEntity;
use Domain\Entities\UserEntity;
use Domain\Entities\UserPasswordEntity;

/**
 * Interface AuthRepositoryInterface
 * @package Infrastructure\Interfaces
 */
interface AuthRepositoryInterface
{
    /**
     * @param array $oldRequest
     * @return UserEntity|null
     */
    public function findUser(array $oldRequest): ?UserEntity;

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
     * @return int
     */
    public function registerUser(array $oldRequest): int;
}
