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

    public function redirectToSocialService($socialServiceName)
    {
        return Socialite::driver($socialServiceName)->redirect();
    }

    public function handleSocialServiceCallback($socialServiceName)
    {
        try {
            $socialUser = Socialite::driver($socialServiceName)->user();
        } catch (Exception $e) {
            return redirect('/login');
        }

        $this->socialService->existsItems($socialUser);

        $userValueObject = $this->socialRepository->findUser($socialUser);
        if (is_null($userValueObject)) {
            $this->socialRepository->registerUser($socialUser);
            $userValueObject = $this->socialRepository->findUser($socialUser);
        }

        $socialAccountValueObject = $this->socialRepository->findSocialAccount($socialServiceName, $socialUser);
        if (is_null($socialAccountValueObject)) {
            $userId = $this->socialRepository->getUserId($socialUser);
            $this->socialRepository->associationSocialAccount($userId, $socialServiceName, $socialUser, $userValueObject);
            $socialAccountValueObject = $this->socialRepository->findSocialAccount($socialServiceName, $socialUser);
        }

        $userId = $this->socialRepository->getUserId($socialUser);

        $socialAccountUserEntity = new SocialUserAccountEntity($userId, $userValueObject, $socialAccountValueObject);

        $this->socialService->socialLogin($socialServiceName, $socialUser, $socialAccountUserEntity);

        return redirect()->to('/home');
    }
}
