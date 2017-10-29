<?php

namespace Infrastructure\Repositories;

use Infrastructure\Interfaces\AuthRepositoryInterface;
use Infrastructure\DataSources\Database\Users;

class AuthRepository implements AuthRepositoryInterface
{
    private $users;

    public function __construct(Users $users)
    {
        $this->users = $users;
    }

    public function findUser($providerUserEmail)
    {
        return $this->users->getUser($providerUserEmail);
    }

    public function registerUser($providerUserEmail, $providerUserName)
    {
        $this->users->setUser($providerUserEmail, $providerUserName);
    }
}