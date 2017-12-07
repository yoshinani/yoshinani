<?php

namespace App\Http\Controllers\Auth;

use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use App\Services\Auth\SocialService as SocialAppService;
use Domain\Services\AuthService as AuthDomainService;
use Exception;

/**
 * Class SocialController
 * @package App\Http\Controllers\Auth
 */
class SocialController extends Controller
{
    private $socialAppService;
    private $authDomainService;

    /**
     * SocialController constructor.
     * @param SocialAppService $socialAppService
     * @param AuthDomainService $authDomainService
     */
    public function __construct(
        SocialAppService $socialAppService,
        AuthDomainService $authDomainService
    ) {
        $this->socialAppService = $socialAppService;
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

        $this->socialAppService->existsItems($socialUser);
        $this->authDomainService->socialLogin($socialServiceName, $socialUser);

        return redirect()->to('/home');
    }
}
