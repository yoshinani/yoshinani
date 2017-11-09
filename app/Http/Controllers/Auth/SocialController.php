<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Domain\Entities\SocialUserAccountEntity;
use Exception;
use Laravel\Socialite\Facades\Socialite;
use App\Services\Auth\AuthService;
use App\Services\Auth\SocialService;
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
            $socialUser = Socialite::driver($provider)->user();
        } catch (Exception $e) {
            return redirect('/login');
        }

        $this->socialService->existsItems($socialUser);

        $userValueObject = $this->socialRepository->findUser($socialUser);
        if (is_null($userValueObject)) {
            $this->socialRepository->registerUser($socialUser);
            $userValueObject = $this->socialRepository->findUser($socialUser);
        }

        $socialAccountValueObject = $this->socialRepository->findSocialAccount($socialUser, $provider);
        if (is_null($socialAccountValueObject)) {
            $userId = $this->socialRepository->getUserId($socialUser);
            $this->socialRepository->associationSocialAccount($socialUser, $provider, $userValueObject, $userId);
            $socialAccountValueObject = $this->socialRepository->findSocialAccount($socialUser, $provider);
        }

        $userId = $this->socialRepository->getUserId($socialUser);

        $socialAccountUserEntity = new SocialUserAccountEntity($userId, $userValueObject, $socialAccountValueObject);

        $this->socialService->socialLogin($socialAccountUserEntity, $socialUser, $provider);

        return redirect()->to('/home');
    }
}
