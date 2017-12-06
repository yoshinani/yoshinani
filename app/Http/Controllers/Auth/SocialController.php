<?php

namespace App\Http\Controllers\Auth;

use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use App\Services\Auth\SocialService;
use Domain\Services\AuthService;
use Exception;

/**
 * Class SocialController
 * @package App\Http\Controllers\Auth
 */
class SocialController extends Controller
{
    private $socialService;
    private $authDomainService;

    /**
     * SocialController constructor.
     * @param SocialService $socialService
     * @param AuthService $authDomainService
     */
    public function __construct(
        SocialService $socialService,
        AuthService $authDomainService
    ) {
        $this->socialService = $socialService;
        $this->authDomainService = $authDomainService;
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
     * @throws Exception
     */
    public function handleSocialServiceCallback($socialServiceName): RedirectResponse
    {
        try {
            $socialUser = Socialite::driver($socialServiceName)->user();
        } catch (Exception $e) {
            return redirect('/login');
        }

        $this->socialService->existsItems($socialUser);
        $socialUserAccountEntity = $this->authDomainService->socialLogin($socialServiceName, $socialUser);
        $this->socialService->socialLogin($socialServiceName, $socialUser, $socialUserAccountEntity);

        return redirect()->to('/home');
    }
}
