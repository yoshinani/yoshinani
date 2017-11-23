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
     * @param array $oldRequest
     * @return mixed
     */
    public function registerUser(array $oldRequest);
}
