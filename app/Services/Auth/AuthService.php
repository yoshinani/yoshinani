<?php

namespace App\Services\Auth;

use Auth;
use Domain\Entities\UserEntity;
use Domain\Entities\UserPasswordEntity;
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
     * @param UserPasswordEntity $userPasswordEntity
     * @throws Exception
     * @internal param string $userId
     */
    public function login(array $oldRequest, UserEntity $userEntity, UserPasswordEntity $userPasswordEntity)
    {
        if (is_null($userEntity)) {
            throw new Exception('User does not exist');
        }

        if (is_null($userPasswordEntity)) {
            throw new Exception('Password does not exist');
        }

        if (!$oldRequest['email'] == $userEntity->getUserEmail()) {
            throw new Exception('email does not match');
        }

        if (!$oldRequest['password'] == $userPasswordEntity->getPassword()) {
            throw new Exception('password does not match');
        }

        if (!Auth::loginUsingId($userEntity->getUserId(), true)) {
            throw new Exception('It is a User that does not exist');
        }
    }

    public function logout()
    {
        Auth::logout();
    }

}
