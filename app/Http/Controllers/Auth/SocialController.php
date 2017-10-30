<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Domain\Services\Auth\AuthService;
use Domain\Services\Auth\SocialService;
use Infrastructure\Interfaces\AuthRepositoryInterface;
Use Infrastructure\Interfaces\SocialRepositoryInterface;

class SocialController extends Controller
{
    private $authService;
    private $socialService;
    private $authRepository;
    private $socialRepository;

    public function __construct(
        AuthService   $authService,
        SocialService $socialService,
        AuthRepositoryInterface $authRepository,
        SocialRepositoryInterface $socialRepository
    ) {
        $this->authService   = $authService;
        $this->socialService = $socialService;
        $this->authRepository = $authRepository;
        $this->socialRepository = $socialRepository;
    }

    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        try {
            $providerUser = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            return redirect('/login');
        }

        $this->socialService->existsItems($providerUser);

        $user = $this->authRepository->findUser($providerUser);
        if (is_null($user)) {
            $this->authRepository->registerUser($providerUser);
            $user = $this->authRepository->findUser($providerUser);
            $this->socialRepository->associationSocialAccount($providerUser, $provider, $user);
        } else {
            $socialAccount = $this->socialRepository->findSocialAccount($providerUser, $provider);
            if (is_null($socialAccount)) {
                $this->socialRepository->associationSocialAccount($providerUser, $provider, $user);
            }
        }

        $this->socialService->socialLogin($user);

        return redirect()->to('/home');
    }
}
