<?php

namespace Domain\Services\Auth;

use DB;
use Laravel\Socialite\Contracts\User;
use App\Repositories\AuthRepositoryInterface;

class AuthService
{
    private $authRepository;

    public function __construct(AuthRepositoryInterface $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function findUser(User $providerUser)
    {
        $providerUserEmail = $providerUser->getEmail();
        return $this->authRepository->findUser($providerUserEmail);
    }

    public function registerUser(User $providerUser)
    {
        $providerUserEmail = $providerUser->getEmail();
        $providerUserName  = $providerUser->getName();
        return $this->authRepository->registerUser($providerUserEmail, $providerUserName);
    }
}