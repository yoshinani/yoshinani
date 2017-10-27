<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Domain\Services\Auth\SocialService;

class SocialController extends Controller
{
    private $socialService;

    public function __construct(
        SocialService $authService
    ) {
        $this->socialService = $authService;
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

        $user = $this->socialService->findUser($providerUser);
        if (is_null($user)) {
            $this->socialService->registerUser($providerUser);
            $user = $this->socialService->findUser($providerUser);
            $this->socialService->associationSocialAccount($providerUser, $provider, $user);
        } else {
            $socialAccount = $this->socialService->findSocialAccount($providerUser, $provider);
            if (is_null($socialAccount)) {
                $this->socialService->associationSocialAccount($providerUser, $provider, $user);
            }
        }

        $this->socialService->socialLogin($user);

        return redirect()->to('/home');
    }
}
