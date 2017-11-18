<?php

namespace App\Services\Auth;

use Auth;
use Domain\Entities\UserEntity;
use Exception;

/**
 * Class AuthService
 * @package App\Services\Auth
 */
class AuthService
{
    /**
     * @param array $oldRequest
     * @param UserEntity $userEntity
     * @throws Exception
     * @internal param string $userId
     */
    public function login(array $oldRequest, UserEntity $userEntity)
    {
        if (!$oldRequest['email'] == $userEntity->getUserEmail()) {
            throw new Exception('email does not match');
        }

        if (!$oldRequest['password'] == $userEntity->getUserPassword()) {
            throw new Exception('password does not match');
        }

        if (!Auth::loginUsingId($userEntity->getUserId(), true)) {
            throw new Exception('It is a User that does not exist');
        }
    }

}
