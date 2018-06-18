<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Domain\Services\AuthService;
use Domain\Services\SocialService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Infrastructure\Interfaces\UserRepositoryInterface;

/**
 * Class SocialController
 * @package App\Http\Controllers\Auth
 */
class SocialController extends Controller
{
    private $authService;
    private $socialService;
    private $userRepository;

    /**
     * SocialController constructor.
     * @param AuthService $authService
     * @param SocialService $socialService
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(
        AuthService $authService,
        SocialService $socialService,
        UserRepositoryInterface $userRepository
    ) {
        $this->authService    = $authService;
        $this->socialService  = $socialService;
        $this->userRepository = $userRepository;
    }

    /**
     * @param $driverName
     * @return RedirectResponse
     */
    public function redirectToProvider($driverName): RedirectResponse
    {
        return $this->socialService->redirectToProvider($driverName);
    }

    /**
     * @param $driverName
     * @return RedirectResponse
     * @throws Exception
     */
    public function handleProviderCallback($driverName): RedirectResponse
    {
        try {
            $socialUser = $this->socialService->getSocialUser($driverName);
        } catch (Exception $e) {
            return redirect('/login')->with('message', 'ログインに失敗しました');
        }

        $result = $this->authService->socialLogin($driverName, $socialUser);
        if (!$result) {
            return redirect('/login')->with('message', 'ログインに失敗しました');
        }

        $userEntity = $this->userRepository->getUser($socialUser->getEmail());

        return redirect('/home')->with('message', 'ようこそ ' . $userEntity->getName() . ' さん');
    }
}
