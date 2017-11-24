<?php

namespace Infrastructure\Interfaces;

/**
 * Interface AuthRepositoryInterface
 * @package Infrastructure\Interfaces
 */
interface AuthRepositoryInterface
{
    /**
     * @param array $oldRequest
     * @return mixed
     */
    public function findUser(array $oldRequest);

    /**
     * @param int $userId
     * @return mixed
     */
    public function getUserPassword(int $userId);

    /**
     * @param string $email
     * @return mixed
     */
    public function getUserId(string $email);

    /**
     * @param int $userId
     * @return mixed
     */
    public function getUserDetail(int $userId);

    /**
     * @param array $oldRequest
     * @return mixed
     */
    public function registerUser(array $oldRequest);
}
