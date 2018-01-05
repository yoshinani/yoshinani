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
     * @param $driverName
     * @return RedirectResponse
     */
    public function redirectToSocialService($driverName): RedirectResponse
    {
        return Socialite::driver($driverName)->redirect();
    }

    /**
     * @param $driverName
     * @return RedirectResponse
     * @throws Exception
     */
    public function handleSocialServiceCallback($driverName): RedirectResponse
    {
        try {
            $socialUser = Socialite::driver($driverName)->user();
        } catch (Exception $e) {
            return redirect('/login')->with('message', 'ログインに失敗しました');
        }

        $userEntity = $this->authDomainService->socialRegisterUser($socialUser);
        
        $result = $this->authDomainService->socialLogin($driverName, $socialUser, $userEntity->getUserId());
        if (!$result) {
            return redirect('/login')->with('message', 'ログインに失敗しました');
        }

        return redirect('/home')->with('message', 'ようこそ '.$userEntity->getUserName().' さん');
    }
}
