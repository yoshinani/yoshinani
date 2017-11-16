<?php

namespace App\Services\Auth;

use Auth;
use Exception;

/**
 * Class AuthService
 * @package App\Services\Auth
 */
class AuthService
{
    /**
     * @param string $userId
     * @throws Exception
     */
    public function idLogin(string $userId)
    {
        if (!Auth::loginUsingId($userId)) {
            throw new Exception('It is a User that does not exist');
        }
    }
}
