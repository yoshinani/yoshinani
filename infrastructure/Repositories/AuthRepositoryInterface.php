<?php

namespace App\Repositories;

interface AuthRepositoryInterface
{
    public function findUser($providerUserEmail);
    public function registerUser($providerUserEmail, $providerUserName);
}