<?php

namespace Infrastructure\Interfaces;

use Laravel\Socialite\Contracts\User as ProviderUser;

interface AuthRepositoryInterface
{
    public function findUser(ProviderUser $providerUser);
    public function registerUser(ProviderUser $providerUser);
}