<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Auth;
use Exception;
use Laravel\Socialite\Facades\Socialite;
use Domain\Services\Auth\AuthService;
use Domain\Services\Auth\SocialService;
Use Infrastructure\Interfaces\SocialRepositoryInterface;

class SocialController extends Controller
{
    private $authService;
    private $socialService;
    private $socialRepository;

    public function __construct(
        AuthService   $authService,
        SocialService $socialService,
        SocialRepositoryInterface $socialRepository
    ) {
        $this->authService   = $authService;
        $this->socialService = $socialService;
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
        } catch (Exception $e) {
            return redirect('/login');
        }

        $this->socialService->existsItems($providerUser);

        $userValueObject = $this->socialRepository->findUser($providerUser);
        if (is_null($userValueObject)) {
            $userId = $this->socialRepository->registerUser($providerUser, $provider);
            $userValueObject = $this->socialRepository->findUser($providerUser);
            $this->socialRepository->associationSocialAccount($providerUser, $provider, $userValueObject, $userId);
        } else {
            $providerUserValueObject = $this->socialRepository->findSocialAccount($providerUser, $provider);
            if (is_null($providerUserValueObject)) {
                $userId = $this->socialRepository->getUserId($providerUser);
                $this->socialRepository->associationSocialAccount($providerUser, $provider, $userValueObject, $userId);
            }
            $userId = $this->socialRepository->getUserId($providerUser);
        }

        if (!Auth::loginUsingId($userId)) {
            throw new Exception('It is a User that does not exist');
        }

        return redirect()->to('/home');
    }
}
