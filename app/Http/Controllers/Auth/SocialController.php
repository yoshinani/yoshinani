<?php
namespace App\Http\Controllers\Auth;

use Infrastructure\Interfaces\Auth\ManualRepositoryInterface;
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
    private $manualRepository;

    /**
     * SocialController constructor.
     * @param AuthDomainService $authDomainService
     * @param ManualRepositoryInterface $manualRepository
     */
    public function __construct(
        AuthDomainService $authDomainService,
        ManualRepositoryInterface $manualRepository
    ) {
        $this->authDomainService = $authDomainService;
        $this->manualRepository  = $manualRepository;
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

        $result = $this->authDomainService->socialLogin($driverName, $socialUser);
        if (!$result) {
            return redirect('/login')->with('message', 'ログインに失敗しました');
        }

        $userEntity = $this->manualRepository->findUser($socialUser->getEmail());

        return redirect('/home')->with('message', 'ようこそ ' . $userEntity->getName() . ' さん');
    }
}
