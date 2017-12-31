<?php

namespace App\Http\Controllers\Auth;

use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use Domain\Services\Auth\SocialService as AuthDomainService;
use Exception;

/**
 * Class SocialController
 * @package App\Http\Controllers\Auth
 */
class SocialController extends Controller
{
    private $authDomainService;

    /**
     * SocialController constructor.
     * @param AuthDomainService $authDomainService
     */
    public function __construct(
        AuthDomainService $authDomainService
    ) {
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

        $userEntity = $this->authDomainService->socialRegisterUser($socialUser);
        
        $result = $this->authDomainService->socialLogin($socialServiceName, $socialUser);
        if (!$result) {
            return back()->with('message', 'ログインに失敗しました');
        }

        return redirect('/home')->with('message', 'ようこそ '.$userEntity->getUserName().' さん');
    }
}
