<?php

namespace Infrastructure\Interfaces;

interface AuthRepositoryInterface
{
    public function findUser($providerUserEmail);
    public function registerUser($providerUserEmail, $providerUserName);
}