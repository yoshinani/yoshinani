<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Domain\Services\Auth\SocialService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Infrastructure\Interfaces\Auth\ManualRepositoryInterface;
use Socialite;

/**
 * Class SocialController
 * @package App\Http\Controllers\Auth
 */
class SocialController extends Controller
{
    private $socialService;
    private $manualRepository;

    /**
     * SocialController constructor.
     * @param SocialService $socialService
     * @param ManualRepositoryInterface $manualRepository
     */
    public function __construct(
        SocialService $socialService,
        ManualRepositoryInterface $manualRepository
    ) {
        $this->socialService = $socialService;
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

        $result = $this->socialService->socialLogin($driverName, $socialUser);
        if (!$result) {
            return redirect('/login')->with('message', 'ログインに失敗しました');
        }

        $userEntity = $this->manualRepository->getUser($socialUser->email);

        return redirect('/home')->with('message', 'ようこそ ' . $userEntity->getName() . ' さん');
    }
}
