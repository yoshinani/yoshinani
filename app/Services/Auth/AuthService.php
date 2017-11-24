<?php

namespace App\Services\Auth;

use Auth;
use Domain\Entities\UserDetailEntity;
use Exception;

/**
 * Class AuthService
 * @package App\Services\Auth
 */
class AuthService
{
    /**
     * @param array $oldRequest
     * @param UserDetailEntity $userDetailEntity
     * @throws Exception
     */
    public function login(array $oldRequest, UserDetailEntity $userDetailEntity)
    {

        if (!$oldRequest['email'] == $userDetailEntity->getUserEmail()) {
            throw new Exception('email does not match');
        }

        if (!$oldRequest['password'] == $userDetailEntity->getPassword()) {
            throw new Exception('password does not match');
        }

        if (!Auth::loginUsingId($userDetailEntity->getUserId(), true)) {
            throw new Exception('It is a User that does not exist');
        }
    }

    public function logout()
    {
        Auth::logout();
    }

}
