<?php
namespace App\Http\Controllers\Auth;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Controllers\Controller;
use Domain\Services\Auth\ManualService as AuthDomainService;
use Infrastructure\Interfaces\Auth\ManualRepositoryInterface;

/**
 * Class ManualController
 * @package App\Http\Controllers\Auth
 */
class ManualController extends Controller
{
    private $manualRepository;
    private $authDomainService;

    public function __construct(
        ManualRepositoryInterface $manualRepository,
        AuthDomainService $authService
    ) {
        $this->manualRepository  = $manualRepository;
        $this->authDomainService = $authService;
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
        $userEntity = $this->authDomainService->registerUser($oldRequest);
        $result     = $this->authDomainService->login($oldRequest, $userEntity->getUserId());
        if (!$result) {
            return back()->with('message', 'ログインに失敗しました');
        }

        return redirect('/home')->with('message', 'ようこそ ' . $userEntity->getUserName() . ' さん');
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
        $userEntity = $this->manualRepository->findUser($oldRequest['email']);
        $result     = $this->authDomainService->login($oldRequest, $userEntity->getUserId());
        if (!$result) {
            return back()->with('message', 'ログインに失敗しました');
        }

        return redirect('/home')->with('message', 'ようこそ ' . $userEntity->getUserName() . ' さん');
    }

    /**
     * @return RedirectResponse
     */
    public function logout()
    {
        \Auth::logout();

        return redirect()->to('/login');
    }
}
