<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use Domain\Services\AuthService;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Infrastructure\Interfaces\ManualRepositoryInterface;

/**
 * Class ManualController
 * @package App\Http\Controllers\Auth
 */
class ManualController extends Controller
{
    private $manualRepository;
    private $authService;
    private $authManager;

    public function __construct(
        ManualRepositoryInterface $manualRepository,
        AuthService $authService,
        AuthManager $authManager
    ) {
        $this->manualRepository  = $manualRepository;
        $this->authService       = $authService;
        $this->authManager       = $authManager->guard('web');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function registerEdit()
    {
        return view('auth.register.edit');
    }

    /**
     * @param RegisterRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function confirmationRegister(RegisterRequest $request)
    {
        $request->flash();

        return view('auth.register.confirmation');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws \Exception
     */
    public function completeRegister(Request $request)
    {
        $oldRequest = $request->old();
        $userEntity = $this->authService->registerUser($oldRequest);
        $result     = $this->authService->login($oldRequest, $userEntity);
        if (!$result) {
            return back()->with('message', 'ログインに失敗しました');
        }

        return redirect('/home')->with('message', 'ようこそ ' . $userEntity->getName() . ' さん');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function loginEdit()
    {
        return view('auth.login.edit');
    }

    /**
     * @param LoginRequest $request
     * @return RedirectResponse
     * @throws \Exception
     */
    public function login(LoginRequest $request)
    {
        $request->flash();
        $oldRequest = $request->old();
        $userEntity = $this->manualRepository->getUser($oldRequest['email']);
        $result     = $this->authService->login($oldRequest, $userEntity);
        if (!$result) {
            return back()->with('message', 'ログインに失敗しました');
        }

        return redirect('/home')->with('message', 'ようこそ ' . $userEntity->getName() . ' さん');
    }

    /**
     * @return RedirectResponse
     */
    public function logout()
    {
        $this->authManager->logout();

        return redirect()->to('/login');
    }
}
