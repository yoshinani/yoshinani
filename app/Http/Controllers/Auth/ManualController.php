<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\Auth\AuthService;
use Infrastructure\Interfaces\AuthRepositoryInterface;

/**
 * Class ManualController
 * @package App\Http\Controllers\Auth
 */
class ManualController extends Controller
{
    private $authRepository;
    private $authService;

    /**
     * ManualController constructor.
     * @param AuthRepositoryInterface $authRepository
     * @param AuthService $authService
     */
    public function __construct(
        AuthRepositoryInterface $authRepository,
        AuthService $authService
    )
    {
        $this->authRepository = $authRepository;
        $this->authService = $authService;
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function completeRegister(Request $request)
    {
        $oldRequest = $request->old();
        $userId = $this->authRepository->registerUser($oldRequest);
        $this->authService->login($userId);
        return redirect()->to('/home');
    }

    public function loginEdit()
    {
        return view('auth.login.edit');
    }

    public function login(Request $request)
    {
        $request->flash();
        $oldRequest = $request->old();
        $userEntity = $this->authRepository->findUser($oldRequest);
        $this->authService->login($oldRequest, $userEntity);
        return redirect()->to('/home');
    }
}
