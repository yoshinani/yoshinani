<?php

namespace Infrastructure\Repositories;

use Infrastructure\Interfaces\AuthRepositoryInterface;
use Infrastructure\DataSources\Database\Users;
use Laravel\Socialite\Contracts\User as ProviderUser;

class AuthRepository implements AuthRepositoryInterface
{
    private $users;

    public function __construct(Users $users)
    {
        $this->users = $users;
    }

    public function findUser(ProviderUser $providerUser)
    {
        $providerUserEmail = $providerUser->getEmail();
        return $this->users->getUser($providerUserEmail);
    }

    public function registerUser(ProviderUser $providerUser)
    {
        $providerUserEmail = $providerUser->getEmail();
        $providerUserName  = $providerUser->getName();
        $this->users->setUser($providerUserEmail, $providerUserName);
    }
}