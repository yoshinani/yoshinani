<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\RedirectResponse;
use Laravel\Socialite\Facades\Socialite;
use App\Services\Auth\{
    AuthService,
    SocialService
};
use Infrastructure\Interfaces\SocialRepositoryInterface;

/**
 * Class SocialController
 * @package App\Http\Controllers\Auth
 */
class SocialController extends Controller
{
    private $authService;
    private $socialService;
    private $socialRepository;

    /**
     * SocialController constructor.
     * @param AuthService $authService
     * @param SocialService $socialService
     * @param SocialRepositoryInterface $socialRepository
     */
    public function __construct(
        AuthService   $authService,
        SocialService $socialService,
        SocialRepositoryInterface $socialRepository
    ) {
        $this->authService = $authService;
        $this->socialService = $socialService;
        $this->socialRepository = $socialRepository;
    }

    /**
     * @param $socialServiceName
     * @return RedirectResponse
     */
    public function redirectToSocialService($socialServiceName): RedirectResponse
    {
        return Socialite::driver($socialServiceName)->redirect();
    }

    /**
     * @param $socialServiceName
     * @return RedirectResponse
     */
    public function handleSocialServiceCallback($socialServiceName): RedirectResponse
    {
        try {
            $socialUser = Socialite::driver($socialServiceName)->user();
        } catch (Exception $e) {
            return redirect('/login');
        }

        $this->socialService->existsItems($socialUser);

        $socialUserAccountEntity = $this->socialRepository->login($socialServiceName, $socialUser);
        $this->socialService->socialLogin($socialServiceName, $socialUser, $socialUserAccountEntity);

        return redirect()->to('/home');
    }
}
