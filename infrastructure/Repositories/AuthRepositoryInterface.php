<?php

namespace Infrastructure\Repositories;

interface AuthRepositoryInterface
{
    public function findUser($providerUserEmail);
    public function registerUser($providerUserEmail, $providerUserName);
}