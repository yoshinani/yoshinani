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

}